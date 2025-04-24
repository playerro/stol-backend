<?php

namespace App\Telegram\Handlers;

use App\Services\TelegramService;
use SergiX44\Nutgram\Nutgram;

class MessageHandler
{
    public function __construct(protected  TelegramService $telegramService)
    {
    }
    public function __invoke(Nutgram $bot): void
    {
        $this->telegramService->handleMessage($bot, $bot->message()->getText());
    }
}
