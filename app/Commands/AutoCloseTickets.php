<?php

namespace App\Commands;

use App\Enums\SupportTicketStatus;
use App\Models\Support\SupportTicket;
use Illuminate\Console\Command;

class AutoCloseTickets extends Command
{
    protected $signature = 'support:autoclose';
    protected $description = 'Auto-close answered tickets after 72 hours without user reply';

    public function handle(): int
    {
        $count = SupportTicket::query()
            ->where('status', SupportTicketStatus::Answered->value)
            ->where('last_admin_reply_at', '<=', now()->subHours(72))
            ->update(['status' => SupportTicketStatus::Closed->value, 'closed_at' => now()]);

        $this->info("Closed {$count} ticket(s).");
        return self::SUCCESS;
    }
}
