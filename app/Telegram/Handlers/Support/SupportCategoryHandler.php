<?php

namespace App\Telegram\Handlers\Support;

use App\Enums\SupportCategory;
use App\Services\Support\SupportStateStore;
use App\Telegram\Support\SupportKeyboards;
use SergiX44\Nutgram\Nutgram;

class SupportCategoryHandler
{
    public function __construct(protected SupportStateStore $state) {}

    public function __invoke(Nutgram $bot): void
    {
        try { $bot->answerCallbackQuery(); } catch (\Throwable) {}

        $data = (string)($bot->callbackQuery()?->data ?? '');
        if (!str_starts_with($data, 'support.cat.')) {
            return;
        }

        $val = substr($data, strlen('support.cat.'));
        $category = SupportCategory::tryFromValue($val);
        if (!$category) return;

        $chatId = $bot->chatId();
        $s = $this->state->get($chatId);
        $s['category'] = $category->value;
        $s['topic'] = null;
        $s['text']  = null;
        $s['stage'] = 'choose_topic'; //изменено — для всех категорий показываем список тем (в т.ч. Другое)
        $this->state->put($chatId, $s);

        $text = $this->askTextForCategory($category); //изменено

        try {
            $bot->sendMessage(
                text: $text,                              //изменено
                chat_id: $chatId,
                reply_markup: SupportKeyboards::topics($category) //изменено — всегда показываем кнопки тем
            );
        } catch (\Throwable) {
            try {
                $bot->sendMessage(text: $text, chat_id: $chatId); // fallback
            } catch (\Throwable) {}
        }
    }

    /** Тексты по ТЗ для шага выбора темы. */ //изменено
    private function askTextForCategory(SupportCategory $category): string //изменено
    {
        return match ($category) { //изменено
            SupportCategory::Points     => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло с баллами.",
            SupportCategory::Purchase   => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло с покупкой.",
            SupportCategory::Scan       => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло при сканировании.",
            SupportCategory::Bug        => "Спасибо!\nТеперь, пожалуйста, выбери, какой баг ты заметил.",              //изменено
            SupportCategory::Rank       => "Спасибо!\nТеперь, пожалуйста, выбери, что именно произошло с рангом.",
            SupportCategory::Cooperation=> "Интересно! Теперь, пожалуйста, выбери интересующий вид сотрудничества.",
            SupportCategory::Other      => "Хм!\nПожалуйста, опиши подробнее, с чем возникла проблема или вопрос.",   //изменено (текст + покажем кнопки)
        };
    }
}
