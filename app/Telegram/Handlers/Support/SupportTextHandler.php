<?php

namespace App\Telegram\Handlers\Support;

use App\Enums\SupportCategory;
use App\Services\Support\SupportStateStore;
use App\Telegram\Support\SupportKeyboards;
use SergiX44\Nutgram\Nutgram;

class SupportTextHandler
{
    public function __construct(protected SupportStateStore $state) {}

    public function __invoke(Nutgram $bot): void
    {
        $chatId = $bot->chatId();
        $s = $this->state->get($chatId);

        if (($s['stage'] ?? null) !== 'await_text') {
            return; // не наша стадия — пропускаем
        }

        $text = trim((string)($bot->message()?->text ?? ''));
        if ($text === '') {
            try { $bot->sendMessage(text: 'Опиши, пожалуйста, текстом.', chat_id: $chatId); } catch (\Throwable) {}
            return;
        }

        $s['text'] = $text;
        $s['stage'] = 'confirm';
        $this->state->put($chatId, $s);

        $catLabel = SupportCategory::tryFromValue((string)$s['category'])?->getLabel() ?? '—';

        try {
            $bot->sendMessage(
                text: "Проверим перед отправкой:\n\nКатегория: {$catLabel}\nТема: {$s['topic']}\n\nКомментарий:\n{$s['text']}",
                chat_id: $chatId,
                reply_markup: SupportKeyboards::confirm()
            );
        } catch (\Throwable) {}
    }
}
