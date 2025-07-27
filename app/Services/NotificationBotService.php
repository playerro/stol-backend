<?php

namespace App\Services;

use App\Filament\Resources\ReceiptResource;
use App\Models\Receipt;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class NotificationBotService
{
    public function __construct(protected Nutgram $bot)
    {
    }

    public function notifyAdmins(Receipt $receipt): void
    {
        $user    = $receipt->tgUser;
        $url     = ReceiptResource::getUrl('edit', ['record' => $receipt]);
        $message = "Пользователь {$user->telegram_id} загрузил чек на сумму: {$receipt->total_sum} ₽.\n"
            . "Проверьте по ссылке: {$url}";

        foreach (config('nutgram.admins') as $chatId) {
            $this->bot->sendMessage(text: $message, chat_id: $chatId, disable_web_page_preview: true);
        }
    }
}
