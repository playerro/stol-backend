<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RejectionReason: string implements HasLabel
{
    case NOT_RESTAURANT    = 'not_restaurant';     // «Чек не является рестораном»
    case OUTSIDE_RUSSIA    = 'outside_russia';     // «Чек не находится в РФ»
    case QR_NOT_RECOGNIZED = 'qr_not_recognized';  // «Не распознан QR-код»
    case EXPIRED           = 'expired';            // «Прошло более XXX часов»
    case OTHER             = 'other';              // «Другая причина»

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NOT_RESTAURANT => 'Чек не является рестораном',
            self::OUTSIDE_RUSSIA => 'Чек не находится в РФ',
            self::QR_NOT_RECOGNIZED => 'Не распознан QR-код',
            self::EXPIRED => 'Прошло более 96 часов',
            self::OTHER => 'Другая причина',
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
