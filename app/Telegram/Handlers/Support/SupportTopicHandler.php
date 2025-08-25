<?php

namespace App\Telegram\Handlers\Support;

use App\Enums\SupportCategory;
use App\Services\Support\SupportStateStore;
use App\Telegram\Support\SupportKeyboards;
use SergiX44\Nutgram\Nutgram;

class SupportTopicHandler
{
    public function __construct(protected SupportStateStore $state) {}

    public function __invoke(Nutgram $bot): void
    {
        try { $bot->answerCallbackQuery(); } catch (\Throwable) {}

        $data = (string)($bot->callbackQuery()?->data ?? '');
        if (!str_starts_with($data, 'support.topic.')) return;

        $idxStr = substr($data, strlen('support.topic.'));
        if ($idxStr === '' || !ctype_digit($idxStr)) {
            return;
        }
        $idx = (int)$idxStr;

        $chatId = $bot->chatId();
        $s = $this->state->get($chatId);

        $cat = SupportCategory::tryFromValue((string)$s['category']);
        if (!$cat) {
            $this->state->reset($chatId);
            return;
        }

        $options = SupportKeyboards::topicsOptions($cat);
        $topic = $options[$idx] ?? null;
        if ($topic === null) {
            return;
        }

        $s['topic'] = $topic;
        $s['stage'] = 'await_text';
        $this->state->put($chatId, $s);

        // --- тексты по ТЗ ---
        $prompt = match ($cat) {
            SupportCategory::Cooperation => 'Пожалуйста, опиши свое предложение максимально подробно.',
            SupportCategory::Other => match ($topic) {
                'Вопрос по функционалу' => 'Пожалуйста, опиши свой вопрос максимально подробно.',
                'Обратная связь'       => 'Пожалуйста, напиши максимально подробный комментарий.',
                default                 => 'Пожалуйста, опиши свой вопрос или проблему максимально подробно.',
            },
            default => 'Пожалуйста, опиши проблему максимально подробно.',
        };

        try {
            $bot->sendMessage(
                text: $prompt,
                chat_id: $chatId
            );
        } catch (\Throwable) {}
    }
}
