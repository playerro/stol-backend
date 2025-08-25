<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;

enum SupportMessageAuthor: string implements HasLabel
{
    case User  = 'user';
    case Admin = 'admin';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::User  => 'Пользователь',
            self::Admin => 'Админ',
        };
    }
}
