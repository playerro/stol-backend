<?php

namespace App\Services;

use App\Models\Clients\TgUser;
use Exception;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonWebApp;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class TelegramService
{
    public function __construct(protected TgUserService $userService)
    {
    }

    public function handleStart(Nutgram $bot): void
    {
        try {

            if ($bot->user()) {
                $user = $this->userService->getUser($bot);

                $this->sendStartingMessage($bot, $user);

            } else {
                $bot->sendMessage('Не удалось получить пользователя.');
            }
        } catch (Exception $exception) {
            $bot->sendMessage('Произошла ошибка');
        }
    }

    public function handleMessage(Nutgram $bot, string $message = null): void
    {
        try {
            if (! $bot->user()) {
                $bot->sendMessage('Не удалось получить пользователя.');
                return;
            }

            $text = $bot->message()->text;
            $parts = explode(' ', trim($text), 2);
            $referralToken = $parts[1] ?? null;

            $user = $this->userService->getUser($bot, $referralToken);
            $this->sendStartingMessage($bot, $user);

        } catch (Exception $exception) {
            $bot->sendMessage('Произошла ошибка');
        }
    }


    public function sendStartingMessage(Nutgram $bot, TgUser $user): void
    {
        $webAppInfo = $this->userService->getAppLink($user->id);
        $bot->setChatMenuButton(chat_id: $user->telegram_id, menu_button: new MenuButtonWebApp('STOL', $webAppInfo));
        $bot->sendMessage(
            text: 'Приветствуем вас в приложении STOL! Переходите в наше мини-приложение по ссылке ниже',
            reply_markup: InlineKeyboardMarkup::make()->addRow(
                InlineKeyboardButton::make(text: 'Открыть приложение',
                    web_app: $webAppInfo)
            )
        );
    }
}
