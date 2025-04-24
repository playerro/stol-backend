<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReceiptStatus: string implements HasLabel
{
    case PENDING  = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CREATED = 'created';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Модерация',
            self::APPROVED => 'Одобрен',
            self::REJECTED => 'Отказан',
            self::CREATED => 'Создан',
        };
    }
}
