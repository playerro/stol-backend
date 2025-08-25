<?php

namespace App\Telegram\Handlers\Support;

use App\Enums\SupportMessageAuthor;
use App\Enums\SupportTicketStatus;
use App\Models\Clients\TgUser;
use App\Services\Support\SupportStateStore;
use App\Services\SupportService;
use App\Services\TgUserService;
use SergiX44\Nutgram\Nutgram;

class SupportReplyTextHandler
{
    public function __construct(
        protected SupportStateStore $state,
        protected SupportService $support,
        protected TgUserService $users,
    ) {}

    public function __invoke(Nutgram $bot): void
    {
        $chatId = $bot->chatId();
        $ticketId = $this->state->getReplyTicket($chatId);
        if (!$ticketId) {
            return;
        }

        $text = trim((string)($bot->message()?->text ?? ''));
        if ($text === '') {
            try { $bot->sendMessage(text: 'Напиши, пожалуйста, текстом.', chat_id: $chatId); } catch (\Throwable) {}
            return;
        }

        // оставляем проверку пользователя, но id больше не передаём //изменено
        $user = $this->users->getByTelegramId($bot->userId());
        if (!$user) {
            $this->state->clearReply($chatId);
            return;
        }

        // было: appendUserMessage($ticketId, $user->id, $text)
        $this->support->appendUserMessage($ticketId, $text); //изменено

        try {
            $bot->sendMessage(
                text: "Понял, принял, обработал!\n\nАгент Поддержки уже занимается твоим запросом и скоро ответит.\n\nСпасибо за обращение!",
                chat_id: $chatId
            );
        } catch (\Throwable) {}

        $this->state->clearReply($chatId);
    }
}
