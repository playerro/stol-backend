<?php

namespace App\Telegram\Handlers\Support;

use App\Enums\SupportCategory;
use App\Services\Support\SupportStateStore;
use App\Telegram\Support\SupportKeyboards;
use SergiX44\Nutgram\Nutgram;

class SupportBackHandler
{
    public function __construct(
        protected SupportStateStore $state,
        protected SupportStartHandler $startHandler
    ) {}

    public function __invoke(Nutgram $bot): void
    {
        try { $bot->answerCallbackQuery(); } catch (\Throwable) {}

        $data = (string)($bot->callbackQuery()?->data ?? '');
        $chatId = $bot->chatId();

        if ($data === 'support.back.root') {
            // назад к корневым категориям
            ($this->startHandler)($bot);
            return;
        }

        if ($data === 'support.back.topic') {
            // назад к выбору темы в рамках текущей категории — без рестартов //изменено
            $s = $this->state->get($chatId);
            $cat = SupportCategory::tryFromValue((string)$s['category']);
            if (!$cat) {
                ($this->startHandler)($bot);
                return;
            }

            $s['stage'] = 'choose_topic'; //изменено
            $this->state->put($chatId, $s);

            $text = $this->askTextForCategory($cat); //изменено

            try {
                $bot->sendMessage(
                    text: $text, //изменено
                    chat_id: $chatId,
                    reply_markup: SupportKeyboards::topics($cat) //изменено
                );
            } catch (\Throwable) {
                try { $bot->sendMessage(text: $text, chat_id: $chatId); } catch (\Throwable) {}
            }
        }
    }

    /** Такой же текст, как в выборе категории. */ //изменено
    private function askTextForCategory(SupportCategory $category): string //изменено
    {
        return match ($category) { //изменено
            SupportCategory::Points     => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло с баллами.",
            SupportCategory::Purchase   => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло с покупкой.",
            SupportCategory::Scan       => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло при сканировании.",
            SupportCategory::Bug        => "Спасибо!\nТеперь, пожалуйста, выбери, какой баг ты заметил.",
            SupportCategory::Rank       => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло с рангом.",
            SupportCategory::Cooperation=> "Интересно! Теперь, пожалуйста, выбери интересующий вид сотрудничества.",
            SupportCategory::Other      => "Хм!\nПожалуйста, опиши подробнее, с чем возникла проблема или вопрос.",
        };
    }
}
