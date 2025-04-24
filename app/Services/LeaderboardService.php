<?php

namespace App\Services;

use App\Models\Clients\TgUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LeaderboardService
{
    const LIMIT = 100;
    /**
     * Возвращает коллекцию топ‑100 и модель текущего пользователя с позицией
     *
     * @param string $userId
     * @return array{leaders:\Illuminate\Support\Collection, current:TgUser}
     * @throws ModelNotFoundException
     */
    public function getLeaderboardForApi(string $userId): array
    {
        $leaders = TgUser::query()
            ->orderByDesc('points')
            ->orderBy('created_at')
            ->limit(100)
            ->get();

        $leaders->values()->each(function (TgUser $user, int $idx) {
            $user->position = $idx + 1;
        });

        $current = TgUser::where('id', $userId)->firstOrFail();

        if ($leaders->contains(fn($u) => $u->id === $current->id)) {
            $current->position = $leaders->first(fn($u) => $u->id === $current->id)->position;
        } else {
            $count = DB::table('tg_users')
                ->where(function ($q) use ($current) {
                    $q->where('points', '>', $current->points)
                        ->orWhere(function ($q2) use ($current) {
                            $q2->where('points', $current->points)
                                ->where('created_at', '<', $current->created_at);
                        });
                })
                ->count();

            $current->position = $count + 1;
        }

        return [$leaders, $current];
    }
}
