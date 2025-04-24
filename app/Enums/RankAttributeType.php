<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RankAttributeType: string implements HasLabel
{
    case CONDITION = 'condition';
    case BONUS     = 'bonus';

    public function getLabel(): string
    {
        return match ($this) {
            self::CONDITION => 'Условие',
            self::BONUS     => 'Бонус',
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
