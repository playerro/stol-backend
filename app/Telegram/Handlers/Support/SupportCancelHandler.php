<?php

namespace App\Telegram\Handlers\Support;

use App\Services\Support\SupportStateStore;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SupportCancelHandler
{
    public function __construct(protected SupportStateStore $state) {}

    public function __invoke(Nutgram $bot): void
    {
        try { $bot->answerCallbackQuery(); } catch (\Throwable) {}

        $chatId = $bot->chatId();
        $this->state->reset($chatId);

        $kb = InlineKeyboardMarkup::make()->addRow( //изменено
            InlineKeyboardButton::make(text: 'Поддержка', callback_data: 'support.start') //изменено
        );

        try {
            $bot->sendMessage(
                text: 'Отменил обращение. Если что — всегда рядом 🫶',
                chat_id: $bot->chatId(),
                reply_markup: $kb                                           //изменено
            );
        } catch (\Throwable) {}
    }
}
