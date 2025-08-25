<?php

namespace App\Telegram\Handlers\Support;

use App\Services\Support\SupportStateStore;
use SergiX44\Nutgram\Nutgram;
use App\Telegram\Support\SupportKeyboards;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

class SupportStartHandler
{
    private const MASCOT_STORAGE_RELATIVE = 'images/donny1.png';

    public function __construct(protected SupportStateStore $state) {}

    public function __invoke(Nutgram $bot): void
    {
        $chatId = $bot->chatId();

        $this->state->reset($chatId);
        $this->state->clearReply($chatId);

        $photoPath = storage_path(self::MASCOT_STORAGE_RELATIVE);
        if (is_file($photoPath)) {
            try {
                $bot->sendPhoto(
                    photo: InputFile::make($photoPath),
                    chat_id: $chatId,
                    caption: 'Приветствую в разделе поддержки для пользователей STOL!',
                    parse_mode: ParseMode::HTML
                );
            } catch (\Throwable) {}
        }

        try {
            $bot->sendMessage(
                text: "Возникла проблема или вопрос? Я всегда рад помочь!\n\nПожалуйста, выбери категорию, к которой это относится:",
                chat_id: $chatId,
                reply_markup: SupportKeyboards::categories()
            );
        } catch (\Throwable) {}
    }
}
