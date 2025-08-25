<?php

namespace App\Services\Support;

use Illuminate\Support\Facades\Cache;

class SupportStateStore
{
    public const TTL = 345600; // 24h

    private function key(int|string|null $chatId): string
    {
        return 'support:state:'.(string)$chatId;
    }

    public function reset(int|string|null $chatId): void
    {
        Cache::forget($this->key($chatId));
    }

    public function get(int|string|null $chatId): array
    {
        return Cache::get($this->key($chatId), [
            'stage'    => 'root',
            'category' => null,
            'topic'    => null,
            'text'     => null,
        ]);
    }

    public function put(int|string|null $chatId, array $state): void
    {
        Cache::put($this->key($chatId), $state, self::TTL);
    }

    public function setReplyTicket(int|string|null $chatId, int $ticketId): void
    {
        $key = 'support:reply:'.(string)$chatId;
        Cache::put($key, ['ticket_id' => $ticketId], self::TTL);
    }

    public function getReplyTicket(int|string|null $chatId): ?int
    {
        $key = 'support:reply:'.(string)$chatId;
        $val = Cache::get($key);
        return is_array($val) && isset($val['ticket_id']) ? (int)$val['ticket_id'] : null;
    }

    public function clearReply(int|string|null $chatId): void
    {
        Cache::forget('support:reply:'.(string)$chatId);
    }
}
