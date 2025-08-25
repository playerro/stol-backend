<?php

namespace App\Services;

use App\Enums\SupportCategory;
use App\Filament\Resources\ReceiptResource;
use App\Models\Clients\TgUser;
use App\Models\Offer;
use App\Models\Receipt;
use App\Models\Support\SupportMessage;
use App\Models\Support\SupportTicket;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

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

    public function notifyGoldenApplePurchase(TgUser $user, Offer $offer, int $purchaseId): void
    {
        $username = config('app.manager_username');
        $link = "https://t.me/{$username}";
        $text = <<<HTML
<b>Поздравляем с покупкой подарочной карты "{$offer->name}"!</b>

Мне не терпится передать её тебе. Чтобы получить карту на свой аккаунт Золотого Яблока, выполни шаги:

1) перейди в диалог с <b>@{$username}</b> (кнопка ниже)
2) напиши номер телефона, который привязан к твоему аккаунту ЗЯ
3) в течение 24 часов ты получишь подарочную карту
HTML;

        $this->bot->sendMessage(
            text: $text,
            chat_id: $user->telegram_id,
            parse_mode: ParseMode::HTML,
            reply_markup: InlineKeyboardMarkup::make()->addRow(
                InlineKeyboardButton::make(text: 'Открыть диалог', url: $link)
            )
        );
    }

    public function supportNotifyAdminsTicketCreated(SupportTicket $ticket): void
    {
        $userLabel = ($ticket->user?->username) ?? ($ticket->user?->telegram_id) ?? '—';

        $categoryText = $ticket->category instanceof SupportCategory
            ? $ticket->category->getLabel()
            : (string)$ticket->category; //изменено

        $text =
            "🆕 Новый тикет #{$ticket->id}\n\n".
            "Пользователь: {$userLabel}\n".
            "Категория: {$categoryText}\n".
            "Тема: {$ticket->topic}\n\n".
            (filled($ticket->body) ? "Комментарий:\n{$ticket->body}" : '');

        $this->toAdmins($text);
    }

    /** Ответ пользователя в существующем тикете — последнее сообщение */
    public function supportNotifyAdminsTicketReply(SupportTicket $ticket, SupportMessage $lastMessage): void
    {
        $userLabel = ($ticket->user?->username) ?? ($ticket->user?->telegram_id) ?? '—';

        $text =
            "✉️ Новое сообщение в тикете #{$ticket->id}\n\n".
            "Пользователь: {$userLabel}\n\n".
            "Сообщение:\n{$lastMessage->message}";

        $this->toAdmins($text);
    }

    /** Ответ пользователю с кнопками */
    public function supportNotifyUserAnswer(SupportTicket $ticket, string $answer): void
    {
        $chatId = $ticket->user?->telegram_id ?? null;
        if (!$chatId) return;

        $kb = InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(
                    text: 'Вопрос решён',
                    callback_data: 'support.resolved.'.$ticket->id
                ),
                InlineKeyboardButton::make(
                    text: 'Ответить',
                    callback_data: 'support.reply.'.$ticket->id
                ),
            );

        $this->bot->sendMessage(
            text: "Ответ от поддержки:\n\n{$answer}",
            chat_id: $chatId,
            reply_markup: $kb
        );
    }

    /** Простая рассылка администраторам: ожидаем массив chat_id в config('nutgram.admins') */ //изменено
    protected function toAdmins(string $text, ?InlineKeyboardMarkup $kb = null): void
    {
        $admins = config('nutgram.admins');
        if (!is_array($admins) || $admins === []) {
            return;
        }

        foreach ($admins as $chatId) {
            try {
                $this->bot->sendMessage(
                    text: $text,
                    chat_id: $chatId,
                    reply_markup: $kb
                );
            } catch (\Throwable) {
                // не прерываем рассылку
            }
        }
    }

}
