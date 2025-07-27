<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NotificationType: string implements HasLabel
{
    case CHECK_APPROVED     = 'check_approved';
    case CHECK_DECLINED     = 'check_declined';
    case RANK_UP            = 'rank_up';
    case REFERRAL_CREDIT    = 'referral_credit';
    case PURCHASE           = 'purchase';

    public function getLabel(): string
    {
        return match ($this) {
            self::CHECK_APPROVED => 'Успешное сканирование',
            self::CHECK_DECLINED     => 'Чек отклонен',
            self::RANK_UP     => 'Повышение ранга',
            self::PURCHASE     => 'Недавняя покупка',
            self::REFERRAL_CREDIT     => 'Реферальное отчисление',
        };
    }

    public static function options(): array
    {
        return array_column(
            array_map(
                fn(self $c) => ['value' => $c->value, 'label' => $c->getLabel()],
                self::cases()
            ),
            'label',
            'value'
        );
    }
}
