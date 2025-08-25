<?php

namespace App\Telegram\Conversations;

use App\Enums\SupportCategory;
use App\Models\Clients\TgUser;
use App\Services\SupportService;
use App\Services\TgUserService;
use App\Services\NotificationBotService;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SupportConversation extends Conversation
{
    /** Абс. путь в storage/, БЕЗ дисков/URL */
    private const MASCOT_STORAGE_RELATIVE = 'images/donny1.png';

    private ?SupportCategory $category = null;
    private ?string $topic = null;
    private ?string $text = null;

    public function __construct(
        protected TgUserService $userService,
        protected SupportService $support,
        protected NotificationBotService $notify
    ) {}

    /** /support */
    public function start(Nutgram $bot): void
    {
        $chatId = $bot->chatId();

        // 1) Маскот напрямую из storage_path()
        $photoPath = storage_path(self::MASCOT_STORAGE_RELATIVE);
        if (is_file($photoPath)) {
            try {
                $bot->sendPhoto(
                    photo: InputFile::make($photoPath),
                    chat_id: $chatId,
                    caption: 'Приветствую в разделе поддержки для пользователей STOL!',
                    parse_mode: ParseMode::HTML
                );
            } catch (\Throwable $th) {
                $bot->sendMessage($th->getMessage());
            }
        }

        $pairs = [
            [SupportCategory::Points,    SupportCategory::Purchase],
            [SupportCategory::Scan,      SupportCategory::Bug],
            [SupportCategory::Rank,      SupportCategory::Cooperation],
            [SupportCategory::Other,     null], // справа «Отмена»
        ];

        $kb = InlineKeyboardMarkup::make();
        foreach ($pairs as [$left, $right]) {
            $row = [];
            if ($left) {
                $row[] = InlineKeyboardButton::make(
                    text: $left->getLabel(),
                    callback_data: 'support.cat.'.$left->value
                );
            }
            if ($right instanceof SupportCategory) {
                $row[] = InlineKeyboardButton::make(
                    text: $right->getLabel(),
                    callback_data: 'support.cat.'.$right->value
                );
            } else {
                $row[] = InlineKeyboardButton::make(text: 'Отмена', callback_data: 'support.cancel');
            }
            $kb->addRow(...$row);
        }

        try {
            $bot->sendMessage(
                text: "Возникла проблема или вопрос? Я всегда рад помочь!\n\nПожалуйста, выбери категорию, к которой это относится:",
                chat_id: $chatId,
                reply_markup: $kb
            );
        } catch (\Throwable $th) {
            $bot->sendMessage($th->getMessage());
        }

        $this->next('chooseCategory');
    }

    /** выбор категории */
    public function chooseCategory(Nutgram $bot): void
    {
        if ($bot->callbackQuery()) {
            try { $bot->answerCallbackQuery(); } catch (\Throwable) {}
        }
        if (!$bot->callbackQuery()) {
            return;
        }

        $data = $bot->callbackQuery()->data;                                        //изменено: ввели $data

        // обработка Отмены прямо в разговоре (чтобы не дёргать отдельный роут)
        if ($data === 'support.cancel') {                                            //изменено
            try {
                $bot->sendMessage(
                    text: 'Отменил обращение. Если что — всегда рядом 🫶',
                    chat_id: $bot->chatId()
                );
            } catch (\Throwable) {}
            $this->end();                                                            //изменено
            return;                                                                  //изменено
        }

        if (!str_starts_with($data, 'support.cat.')) {                               //изменено
            return;
        }

        $value = explode('support.cat.', $data)[1] ?? null;                          //изменено
        $this->category = SupportCategory::tryFromValue($value);
        if (!$this->category) {
            return;
        }

        if (in_array($this->category, [
            SupportCategory::Points,
            SupportCategory::Purchase,
            SupportCategory::Scan,
            SupportCategory::Bug,
            SupportCategory::Rank,
        ], true)) {
            $this->askTopic($bot);
        } elseif ($this->category === SupportCategory::Cooperation) {
            $this->askCoopType($bot);
        } elseif ($this->category === SupportCategory::Other) {
            $this->askOtherType($bot);
        }
    }

    /** под-типы */
    private function askTopic(Nutgram $bot): void
    {
        $chatId = $bot->chatId();

        $map = [
            SupportCategory::Points->value   => ['Баллы не начислились','Баллы пропали','Другое'],
            SupportCategory::Purchase->value => ['Не пришел товар','Ошибка при оплате','Товар не работает','Другое'],
            SupportCategory::Scan->value     => ['Камера не открывается','QR не считывается','Ошибка сканирования','Другое'],
            SupportCategory::Bug->value      => ['Приложение вылетает','Не работает кнопка','Неправильное отображение данных','Другое'],
            SupportCategory::Rank->value     => ['Ранг не обновился','Ранг сбросился','Неверный ранг','Другое'],
        ];

        $buttons = $map[$this->category->value] ?? ['Другое'];

        $kb = InlineKeyboardMarkup::make();
        foreach ($buttons as $b) {
            $kb->addRow(InlineKeyboardButton::make(text: $b, callback_data: 'support.topic.'.$b));
        }
        $kb->addRow(InlineKeyboardButton::make(text: 'Назад', callback_data: 'support.back.root'));

        try {
            $bot->sendMessage(
                text: "Спасибо! Теперь, пожалуйста, выбери, что именно произошло в категории «{$this->category->getLabel()}».",
                chat_id: $chatId,
                reply_markup: $kb
            );
        } catch (\Throwable) {
            return;
        }

        $this->next('chooseTopic');
    }

    public function chooseTopic(Nutgram $bot): void
    {
        if ($bot->callbackQuery()) {
            try { $bot->answerCallbackQuery(); } catch (\Throwable) {}
        }
        if (!$bot->callbackQuery()) return;

        $data = $bot->callbackQuery()->data;

        if ($data === 'support.back.root') {
            $this->start($bot);
            return;
        }

        if (!str_starts_with($data, 'support.topic.')) return;

        $this->topic = explode('support.topic.', $data)[1];

        try {
            $bot->sendMessage(
                text: 'Пожалуйста, опиши проблему максимально подробно.',
                chat_id: $bot->chatId()
            );
        } catch (\Throwable) {
            return;
        }

        $this->next('collectText');
    }

    private function askCoopType(Nutgram $bot): void
    {
        $kb = InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(text: 'Реклама', callback_data: 'support.topic.Реклама'),
                InlineKeyboardButton::make(text: 'Совместный проект', callback_data: 'support.topic.Совместный проект'),
            )->addRow(
                InlineKeyboardButton::make(text: 'Программа лояльности', callback_data: 'support.topic.Программа лояльности'),
                InlineKeyboardButton::make(text: 'B2B сотрудничество', callback_data: 'support.topic.B2B сотрудничество'),
            )->addRow(
                InlineKeyboardButton::make(text: 'Другое', callback_data: 'support.topic.Другое')
            )->addRow(
                InlineKeyboardButton::make(text: 'Назад', callback_data: 'support.back.root')
            );

        try {
            $bot->sendMessage(
                text: 'Интересно! Теперь выбери интересующий вид сотрудничества.',
                chat_id: $bot->chatId(),
                reply_markup: $kb
            );
        } catch (\Throwable) {
            return;
        }

        $this->next('chooseTopic');
    }

    private function askOtherType(Nutgram $bot): void
    {
        $kb = InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(text: 'Вопрос по функционалу', callback_data: 'support.topic.Вопрос по функционалу'),
                InlineKeyboardButton::make(text: 'Обратная связь', callback_data: 'support.topic.Обратная связь'),
            )->addRow(
                InlineKeyboardButton::make(text: 'Другое', callback_data: 'support.topic.Другое')
            )->addRow(
                InlineKeyboardButton::make(text: 'Назад', callback_data: 'support.back.root')
            );

        try {
            $bot->sendMessage(
                text: 'Хм! Пожалуйста, уточни подробнее, к чему относится вопрос/проблема.',
                chat_id: $bot->chatId(),
                reply_markup: $kb
            );
        } catch (\Throwable) {
            return;
        }

        $this->next('chooseTopic');
    }

    public function collectText(Nutgram $bot): void
    {
        if ($bot->isCallbackQuery()) {
            try { $bot->answerCallbackQuery(); } catch (\Throwable) {}
            return;
        }

        $this->text = trim($bot->message()?->text ?? '');
        if ($this->text === '') {
            try {
                $bot->sendMessage(
                    text: 'Опиши, пожалуйста, текстом.',
                    chat_id: $bot->chatId()
                );
            } catch (\Throwable) {}
            $this->next('collectText');
            return;
        }

        $kb = InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(text: 'Отправить', callback_data: 'support.send'),
                InlineKeyboardButton::make(text: 'Назад', callback_data: 'support.back.topic'),
            );

        try {
            $bot->sendMessage(
                text: "Проверим перед отправкой:\n\nКатегория: {$this->category->getLabel()}\nТема: {$this->topic}\n\nКомментарий:\n{$this->text}",
                chat_id: $bot->chatId(),
                reply_markup: $kb
            );
        } catch (\Throwable) {
            return;
        }

        $this->next('confirmSend');
    }

    public function confirmSend(Nutgram $bot): void
    {
        if ($bot->callbackQuery()) {
            try { $bot->answerCallbackQuery(); } catch (\Throwable) {}
        }
        if (!$bot->callbackQuery()) return;

        $data = $bot->callbackQuery()->data;

        if ($data === 'support.back.topic') {
            $this->askTopic($bot);
            return;
        }
        if ($data !== 'support.send') return;

        /** @var TgUser $user */
        $user = $this->userService->getByTelegramId($bot->userId());
        if (!$user || !$this->category) {
            try {
                $bot->sendMessage(
                    text: 'Не удалось создать тикет. Попробуй позже.',
                    chat_id: $bot->chatId()
                );
            } catch (\Throwable) {}
            $this->end();
            return;
        }

        // создаём тикет
        $ticket = $this->support->openTicket($user, $this->category, $this->topic, $this->text);

        // уведомления
        try {
            $this->notify->supportTicketCreated($user, $ticket);
            $this->notify->supportNotifyAdmins($ticket);
        } catch (\Throwable) {
            // глушим, чтобы не зациклить
        }

        if ($this->category === SupportCategory::Cooperation) {
            try {
                $bot->sendMessage(
                    text: 'Ого, звучит интересно! Я изучу идею и обязательно свяжусь с тобой в ближайшее время🫶',
                    chat_id: $bot->chatId()
                );
            } catch (\Throwable) {}
        }

        $this->end();
    }
}
