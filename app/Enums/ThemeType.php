<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ThemeType: string implements HasLabel
{
    case WhitePink = 'white-pink';
    case GrayBrown = 'gray-brown';
    case GrayBlack = 'gray-black';
    public function getLabel(): ?string
    {
        return match ($this) {
            self::WhitePink => 'white-pink',
            self::GrayBrown => 'gray-brown',
            self::GrayBlack => 'gray-black',
        };
    }
}
