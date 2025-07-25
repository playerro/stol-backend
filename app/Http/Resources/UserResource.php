<?php

namespace App\Http\Resources;

use App\Enums\ReceiptStatus;
use App\Services\RankService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avatar      = $this->getFirstMediaUrl('avatars') ?: null;
        $botUsername = config('app.telegram.bot_username');
        $token       = $this->referral_token;

        // собираем все ранговые данные через сервис
        /** @var RankService $rankService */
        $rankService = app(RankService::class);
        $rankData    = $rankService->getRankData($this->resource);

        return [
            'avatar'        => $avatar,
            'username'      => $this->username ?: 'Неизвестный',
            'app_username'      => $this->app_username,
            'points'        => $this->points,
            'points_remainder' => $this->points_remainder,
            'daily_streak'  => $this->daily_streak,
            'visits'        => $this->visits,
            'average_check' => (string) $this->average_check,
            'telegram_id'   => $this->telegram_id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'theme'         => $this->theme,
            'created_at'    => $this->created_at->toIso8601String(),

            'rank' => [
                'current'             => $rankData['current_name'],
                'next'                => $rankData['next_name'],
                'conditions_current'  => $rankData['conditions_current'],
                'conditions_next'     => $rankData['conditions_next'],
                'progress_current'    => $rankData['progress_current'],
            ],

            'favorite'      => $this->favoriteData,
            'recent'        => $this->recentData,

            'referral_link' => "t.me/{$botUsername}?start={$token}",
        ];
    }
}
