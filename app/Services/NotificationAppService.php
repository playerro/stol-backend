<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Models\Clients\TgUser;
use App\Models\Notification;

class NotificationAppService
{
    public function notifyCheckApproved(TgUser $user, int $points): Notification
    {
        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::CHECK_APPROVED,
            'title'      => 'Чек одобрен',
            'subtitle'   => "Вы получили {$points} балл" . ($points > 1 ? 'ов' : ''),
            'body'       => null,
        ]);
    }

    public function notifyCheckDeclined(TgUser $user, string $reason): Notification
    {
        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::CHECK_DECLINED,
            'title'      => 'Чек отклонён',
            'subtitle'   => $reason,
            'body'       => null,
        ]);
    }

    public function notifyRankUp(TgUser $user, string $newRankName): Notification
    {
        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::RANK_UP,
            'title'      => 'Поздравляем!',
            'subtitle'   => "Вы достигли ранга «{$newRankName}»",
            'body'       => null,
        ]);
    }

    public function notifyReferralCredit(TgUser $user, int $amount, string $referrerUsername): Notification
    {
        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::REFERRAL_CREDIT,
            'title'      => 'Реферальные отчисления',
            'subtitle'   => "Вы получили {$amount} балл" . ($amount > 1 ? 'ов' : '') . " от @{$referrerUsername}",
            'body'       => null,
        ]);
    }

    public function notifyPurchase(TgUser $user, string $offerName, ?string $code = null): Notification
    {
        $subtitle = "Вы купили «{$offerName}»";
        if ($code) {
            $subtitle .= " (код: {$code})";
        }

        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::PURCHASE,
            'title'      => 'Покупка подтверждена',
            'subtitle'   => $subtitle,
            'body'       => null,
        ]);
    }
}
