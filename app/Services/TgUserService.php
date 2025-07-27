<?php

namespace App\Services;

use App\Enums\ReceiptStatus;
use App\Models\Clients\Rank;
use App\Models\Clients\TgUser;
use Carbon\Carbon;
use SebastianBergmann\GlobalState\Exception;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;
use Str;

class TgUserService
{
    private const METRIC_KEYS = [
        'scans'       => 'visits',
        'sum_spent'   => null,
        'streak_days' => 'daily_streak',
    ];

    private const STREAK_WINDOW_SECONDS = 24 * 60 * 60 + 15 * 60;

    public function __construct(protected ReceiptService $receiptService)
    {
    }

    const QUERY = '?query=';

    public function getUser(Nutgram $bot, ?string $referralToken = null)
    {
        $tg = $bot->user();
        $appUser = TgUser::where('telegram_id', $tg->id)->first();

        if ($appUser) {
            return $appUser;
        }
        return $this->registerWithReferral($bot, $tg, $referralToken);
    }

    private function getByTgId($id)
    {
        return TgUser::where(['telegram_id' => $id])->first();
    }

    private function registerWithReferral(Nutgram $bot, ?User $tgUser, ?string $referralToken)
    {
        try {
            $user = TgUser::create([
                'telegram_id' => $tgUser?->id,
                'username' => $tgUser?->username,
                'app_username' => $tgUser?->username,
                'first_name' => $tgUser?->first_name,
                'last_name' => $tgUser?->last_name,
            ]);

            if ($referralToken) {
                $referrer = TgUser::where('referral_token', $referralToken)->first();
                if ($referrer) {
                    $user->referrer_id = $referrer->id;
                    $user->save();
                }
            }

            if ($tmpFile = $this->downloadAvatarTemp($tgUser, $bot)) {
                $user
                    ->addMedia($tmpFile)
                    ->usingFileName(Str::uuid() . '.' . pathinfo($tmpFile, PATHINFO_EXTENSION))
                    ->toMediaCollection('avatars');

                @unlink($tmpFile);
            }

            return $user;
        } catch (Exception $exception) {
            return $bot->sendMessage('Произошла ошибка');
        }
    }

    public function getAppLink($userUuid): WebAppInfo
    {
        $link = config('app.web_app_link');
        $url = $link . self::QUERY. $userUuid;
        return new WebAppInfo($url);
    }

    public function getByUuid(string $uuid)
    {
        return TgUser::where(['id' => $uuid])->first();
    }

    private function downloadAvatarTemp(?User $tgApiUser, Nutgram $bot): ?string
    {
        if (! $tgApiUser) {
            return null;
        }

        $fileId = $this->getLargestProfilePhotoFileId($tgApiUser, $bot);
        if (! $fileId) {
            return null;
        }

        $fileResponse = $bot->getFile($fileId);
        $path         = $fileResponse->file_path ?? null;
        if (! $path) {
            return null;
        }

        $ext     = pathinfo($path, PATHINFO_EXTENSION) ?: 'jpg';
        $tmpFile = tempnam(sys_get_temp_dir(), 'tg_avatar_') . '.' . $ext;

        $bot->downloadFile($fileResponse, $tmpFile);

        return $tmpFile;
    }

    private function getLargestProfilePhotoFileId(User $tgApiUser, Nutgram $bot): ?string
    {
        $photos = $bot->getUserProfilePhotos($tgApiUser->id, 0, 1);
        if (! ($photos->photos[0] ?? false)) {
            return null;
        }

        $sizes = $photos->photos[0];

        usort($sizes, fn($a, $b) => ($b->file_size ?? 0) <=> ($a->file_size ?? 0));

        return $sizes[0]->file_id ?? null;
    }

    public function getUserForApi(string $userId)
    {
        $user = TgUser::with([
            'receipts' => fn($q) => $q->where('status', ReceiptStatus::APPROVED->value),
            'rank.conditions',
        ])->findOrFail($userId);
        $this->updateDailyStreak($user);

        if (! $user->rank_assigned_at) {
            $defaultRank = Rank::orderBy('order')->first();
            $user->update([
                'rank_id'          => $defaultRank->id,
                'rank_assigned_at' => now(),
            ]);
        }

        $user->favoriteData = $this->receiptService->determineFavorite($user);
        $user->recentData   = $this->receiptService->determineRecent($user);
        return $user;
    }

    protected function updateDailyStreak(TgUser $user): void
    {
        $now = Carbon::now();

        if (! $user->last_visit_at) {
            $user->daily_streak = 1;
        } else {
            $diffSeconds = $user->last_visit_at->diffInSeconds($now);

            if ($diffSeconds <= self::STREAK_WINDOW_SECONDS) {
                $user->daily_streak++;
            } else {
                $user->daily_streak = 1;
            }
        }

        $user->last_visit_at = $now;
        $user->save();
    }
    public function updateProfile(string $userId, array $data): TgUser
    {
        $user = TgUser::where('id', $userId)->firstOrFail();

        if (isset($data['username'])) {
            $user->app_username = $data['username'];
        }
        if (isset($data['theme'])) {
            $user->theme = $data['theme'];
        }

        $user->save();

        return $user;
    }

}
