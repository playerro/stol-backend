<?php

namespace App\Telegram\Handlers;

use App\Models\Support\SupportTicket;
use App\Services\Support\SupportStateStore;
use App\Services\SupportService;
use App\Services\NotificationBotService;
use App\Services\TgUserService;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SupportCallbacks
{
    public function __construct(
        protected SupportService $support,
        protected SupportStateStore $state,
    ) {}

    /** support.resolved.{id} */
    public function resolved(Nutgram $bot): void
    {
        try { $bot->answerCallbackQuery(); } catch (\Throwable) {}

        $data = (string)($bot->callbackQuery()?->data ?? '');
        if (!str_starts_with($data, 'support.resolved.')) return;

        $ticketId = (int)substr($data, strlen('support.resolved.'));
        // ставим статус «Закрыт пользователем»
        $this->support->markResolvedByUser($ticketId); // <-- меняет статус в БД

        // подтверждение пользователю
        try {
            $bot->sendMessage(
                text: "Я рад, что смог помочь!\n\nЕсли будут ещё какие-то проблемы или вопросы — пиши",
                chat_id: $bot->chatId()
            );
        } catch (\Throwable) {}
    }

    /** support.reply.{id} */
    public function replyStart(Nutgram $bot): void
    {
        try { $bot->answerCallbackQuery(); } catch (\Throwable) {}

        $data = (string)($bot->callbackQuery()?->data ?? '');
        if (!str_starts_with($data, 'support.reply.')) return;

        $ticketId = (int)substr($data, strlen('support.reply.'));
        // включаем режим ответа для этого чата
        $this->state->setReplyTicket($bot->chatId(), $ticketId);

        try {
            $bot->sendMessage(
                text: 'Пожалуйста, напиши свой комментарий.',
                chat_id: $bot->chatId()
            );
        } catch (\Throwable) {}
    }
}
