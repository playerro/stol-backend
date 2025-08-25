<?php

namespace App\Services;

use App\Enums\SupportCategory;
use App\Enums\SupportMessageAuthor;
use App\Enums\SupportTicketStatus;
use App\Models\Support\SupportMessage;
use App\Models\Support\SupportTicket;
use App\Models\Clients\TgUser;

class SupportService
{
    public function __construct(protected NotificationBotService $notify) {}

    public function openTicket(TgUser $user, SupportCategory $category, string $topic, string $text): SupportTicket //изменено
    {
        $ticket = new SupportTicket();
        $ticket->tg_user_id = $user->id;
        $ticket->category   = $category;                           // каст модели приведёт к строке/лейблу по вашему касту
        $ticket->topic      = $topic;
        $ticket->body       = $text;                               // только исходный комментарий
        $ticket->status     = SupportTicketStatus::New->value;
        $ticket->save();

        // Сразу создаём первое сообщение в переписке — чтобы в админке оно было видно. //изменено
        $msg = new SupportMessage();
        $msg->ticket_id = (int)$ticket->id;
        $msg->author    = SupportMessageAuthor::User->value;
        $msg->message   = $text;
        $msg->created_at = $ticket->created_at; // опционально выравниваем время
        $msg->save();

        return $ticket;
    }

    public function addUserReply(SupportTicket $ticket, string $text): SupportMessage
    {
        $msg = $ticket->messages()->create([
            'author'  => SupportMessageAuthor::User->value,
            'message' => $text,
        ]);

        $ticket->update([
            'status'             => SupportTicketStatus::InProgress->value,
            'last_user_reply_at' => now(),
        ]);

        return $msg;
    }

    public function addAdminReply(SupportTicket $ticket, string $text): SupportMessage
    {
        $msg = $ticket->messages()->create([
            'author'  => SupportMessageAuthor::Admin->value,
            'message' => $text,
        ]);

        $ticket->update([
            'status'              => SupportTicketStatus::Answered->value,
            'last_admin_reply_at' => now(),
        ]);

        return $msg;
    }

    public function close(SupportTicket $ticket): void
    {
        $ticket->update([
            'status'    => SupportTicketStatus::Closed->value,
            'closed_at' => now(),
        ]);
    }

    private function composeSummary(SupportCategory $category, ?string $topic, string $text): string
    {
        $topic = $topic ?: '—';
        return "Категория: {$category->getLabel()}\nТема: {$topic}\nКомментарий:\n{$text}";
    }

    public function markResolvedByUser(int $ticketId): void
    {
        $ticket = SupportTicket::query()->find($ticketId);
        if (!$ticket) return;

        $ticket->status = SupportTicketStatus::Closed->value;
        $ticket->save();
    }

    public function appendUserMessage(int $ticketId, string $text): void
    {
        $ticket = SupportTicket::query()->find($ticketId);
        if (!$ticket) return;

        $msg = new SupportMessage();
        $msg->ticket_id = $ticket->id;
        $msg->author    = SupportMessageAuthor::User->value;
        $msg->message   = $text;
        $msg->save();

        $ticket->status = SupportTicketStatus::New->value;
        $ticket->save();

        try {
            $this->notify->supportNotifyAdminsTicketReply($ticket, $msg);
        } catch (\Throwable) {}
    }

    public function appendAdminMessage(SupportTicket $ticket, string $text): void
    {
        $msg = new SupportMessage();
        $msg->ticket_id = $ticket->id;
        $msg->author    = SupportMessageAuthor::Admin->value;
        $msg->message   = $text; //изменено
        $msg->save();

        $ticket->status = SupportTicketStatus::Answered->value;
        $ticket->save();

        try { $this->notify->supportNotifyUserAnswer($ticket, $text); } catch (\Throwable) {}
    }
}
