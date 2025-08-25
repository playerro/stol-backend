<?php

namespace App\Telegram\Handlers\Support;

use App\Enums\SupportCategory;
use App\Models\Clients\TgUser;
use App\Services\NotificationBotService;
use App\Services\Support\SupportStateStore;
use App\Services\SupportService;
use App\Services\TgUserService;
use SergiX44\Nutgram\Nutgram;

class SupportSendHandler
{
    public function __construct(
        protected SupportStateStore $state,
        protected TgUserService $users,
        protected SupportService $support,
        protected NotificationBotService $notify,
    ) {}

    public function __invoke(Nutgram $bot): void
    {
        try { $bot->answerCallbackQuery(); } catch (\Throwable) {}

        $chatId = $bot->chatId();
        $s = $this->state->get($chatId);

        if (empty($s['category']) || empty($s['topic']) || empty($s['text'])) {
            try { $bot->sendMessage(text: 'Данные неполные, начну заново.', chat_id: $chatId); } catch (\Throwable) {}
            $this->state->reset($chatId);
            return;
        }

        $category = SupportCategory::tryFromValue((string)$s['category']);
        if (!$category) {
            $this->state->reset($chatId);
            return;
        }

        /** @var TgUser|null $user */
        $user = $this->users->getByTelegramId($bot->userId());
        if (!$user) {
            try { $bot->sendMessage(text: 'Не удалось создать тикет. Попробуй позже.', chat_id: $chatId); } catch (\Throwable) {}
            $this->state->reset($chatId);
            return;
        }

        // создаём тикет
        $ticket = $this->support->openTicket($user, $category, (string)$s['topic'], (string)$s['text']);

        // уведомления
        try {
            // $this->notify->supportTicketCreated($user, $ticket); //изменено: убрано, чтобы не дублировались ответы пользователю
            $this->notify->supportNotifyAdminsTicketCreated($ticket);             // остаётся только уведомление админам
        } catch (\Throwable $th) {
            $bot->sendMessage($th->getMessage());
        }

        // --- ЕДИНСТВЕННОЕ сообщение пользователю (по ТЗ) --- //изменено
        $reply = match ($category) {
            SupportCategory::Cooperation =>
            "Ого, звучит интересно!\nЯ изучу идею и обязательно свяжусь с тобой в ближайшее время🙌",
            SupportCategory::Other => match ((string)$s['topic']) {
                'Вопрос по функционалу' =>
                "Понял, принял, обработал!\n\nАгент Поддержки уже занимается твоим запросом и скоро ответит.\n\nСпасибо за обращение!",
                'Обратная связь', 'Другое' =>
                "Спасибо за обратную связь!\n\nЯ внимательно изучу твой комментарий.",
                default =>
                "Спасибо за обратную связь!\n\nЯ внимательно изучу твой комментарий.",
            },
            default =>
            "Понял, принял, обработал!\n\nАгент Поддержки уже занимается твоим запросом и скоро ответит.\n\nСпасибо за обращение!",
        };

        try {
            $bot->sendMessage(text: $reply, chat_id: $chatId);
        } catch (\Throwable) {}

        $this->state->reset($chatId);
    }
}
