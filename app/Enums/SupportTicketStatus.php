<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SupportTicketStatus: string implements HasLabel
{
    case New        = 'new';
    case InProgress = 'in_progress';
    case Answered   = 'answered';
    case Closed     = 'closed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New        => 'Новый',
            self::InProgress => 'В работе',
            self::Answered   => 'Ответ отправлен',
            self::Closed     => 'Закрыт',
        };
    }
}
