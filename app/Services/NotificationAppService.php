<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Enums\RejectionReason;
use App\Models\Clients\Rank;
use App\Models\Clients\TgUser;
use App\Models\Notification;

class NotificationAppService
{
    public function notifyCheckApproved(TgUser $user, float $totalSum, int $points): Notification
    {
        $sumFormatted = sprintf('%.0f', $totalSum);
        $pointsWord  = $this->plural($points, ['балл','балла','баллов']);
        $title       = 'Успешное сканирование';
        $subtitle    = "Начислено {$points} {$pointsWord}";
        $body        = "Чек на {$sumFormatted}₽ принят и твой баланс вырос ещё на {$points} {$pointsWord}. Так держать!";

        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::CHECK_APPROVED,
            'title'      => $title,
            'subtitle'   => $subtitle,
            'body'       => $body,
        ]);
    }

    public function notifyCheckDeclined(TgUser $user, RejectionReason $reason): Notification
    {
        $titles = [
            'default' => 'Чек отклонён',
        ];

        $subtitles = [
            RejectionReason::NOT_RESTAURANT->value    => 'Не является рестораном',
            RejectionReason::OUTSIDE_RUSSIA->value    => 'Не находится в РФ',
            RejectionReason::QR_NOT_RECOGNIZED->value => 'Не распознан QR-код',
            RejectionReason::EXPIRED->value           => 'Прошло более ' . config('receipts.scan_expiration_hours') . ' часов',
            RejectionReason::OTHER->value             => 'Не удалось принять чек',
        ];

        $bodies = [
            RejectionReason::NOT_RESTAURANT->value    => 'Ой-ой! Кажется, этот чек был не из заведения. Я такие не принимаю!',
            RejectionReason::OUTSIDE_RUSSIA->value    => 'Ой-ой! Кажется, чек был не из России. Я такие не принимаю!',
            RejectionReason::QR_NOT_RECOGNIZED->value => 'Эх… видимо QR-код не пропечатан или не читается. Попробуйте ещё раз?',
            RejectionReason::EXPIRED->value           => 'Прошло слишком много времени с момента покупки. Попробуйте другой чек.',
            RejectionReason::OTHER->value             => 'Что-то пошло не так. Попробуйте ещё раз или обратитесь в поддержку.',
        ];

        $key = $reason->value;

        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::CHECK_DECLINED,
            'title'      => $titles['default'],
            'subtitle'   => $subtitles[$key]   ?? $subtitles[RejectionReason::OTHER->value],
            'body'       => $bodies[$key]      ?? $bodies[RejectionReason::OTHER->value],
        ]);
    }

    public function notifyRankUp(TgUser $user, Rank $newRank): Notification
    {
        $bodies = [
            1 => 'Приветствую в STOl! Это твой 1-ый ранг. Сканируй чеки и повышай его!',
            2 => 'Поздравляю! Ты перешел на 2-ой ранг. Продолжай в том же духе!',
            3 => 'Вау, ты уже на 3-ем ранге! У тебя круто получается!',
            4 => 'Ты растешь прямо на глазах! Теперь у тебя 4-ый ранг!',
            5 => 'Не перестаю удивляться твоему успеху! Поздравляю с 5-ым рангом!',
            6 => 'Вот это да! Ты достиг 6-ого ранга! Добро пожаловать в элиту!',
            7 => 'У меня просто нет слов… Ты достиг высшего ранга в нашем приложении!',
        ];

        $order = $newRank->order;
        $body  = $bodies[$order] ?? null;

        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::RANK_UP,
            'title'      => 'Повышение ранга',
            'subtitle'   => "Получен ранг «{$newRank->name}»",
            'body'       => $body,
        ]);
    }

    public function notifyReferralCredit(TgUser $user, int $amount): Notification
    {
        $pointsWord = $this->plural($amount, ['балл', 'балла', 'баллов']);
        $title      = 'Реферальные отчисления';
        $subtitle   = "Начислено {$amount} {$pointsWord}";
        $body       = "А ты со связями :) У твоего реферала принятый чек и ты получил {$amount} {$pointsWord}!";

        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::REFERRAL_CREDIT,
            'title'      => $title,
            'subtitle'   => $subtitle,
            'body'       => $body,
        ]);
    }

    public function notifyPurchase(TgUser $user, string $offerName, ?string $code = null): Notification
    {
        $title    = 'Недавняя покупка';
        $subtitle = "Куплен «{$offerName}»";

        if ($code) {
            $subtitle .= " (код: {$code})";
        }

        $body = "{$offerName} будет начислен на твой аккаунт в течении 24 часов. Спасибо за покупку!";

        return Notification::create([
            'tg_user_id' => $user->id,
            'type'       => NotificationType::PURCHASE,
            'title'      => $title,
            'subtitle'   => $subtitle,
            'body'       => $body,
        ]);
    }


    private function plural(int $n, array $forms): string
    {
        $n10 = $n % 10;
        $n100 = $n % 100;
        if ($n10 === 1 && $n100 !== 11) {
            return $forms[0];
        }
        if ($n10 >= 2 && $n10 <= 4 && ($n100 < 10 || $n100 >= 20)) {
            return $forms[1];
        }
        return $forms[2];
    }
}
