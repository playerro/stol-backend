<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
enum SupportCategory: string implements HasLabel
{
    case Points        = 'Баллы';
    case Purchase      = 'Покупка';
    case Scan          = 'Сканирование';
    case Bug           = 'Баг';
    case Rank          = 'Ранг';
    case Cooperation   = 'Сотрудничество';
    case Other         = 'Другое';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public static function tryFromValue(?string $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }
        return null;
    }
}
