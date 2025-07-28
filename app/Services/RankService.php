<?php

namespace App\Services;

use App\Enums\ReceiptStatus;
use App\Models\Clients\Rank;
use App\Models\Clients\TgUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class RankService
{

    public function updateUserRank(TgUser $user): void
    {
        $nextRank = $this->getNextRank($user);
        if (! $nextRank) {
            return;
        }

        $metrics = $this->gatherMetricsSinceLastRank($user);

        if (! $this->meetsAllConditions($nextRank, $metrics)) {
            return;
        }

        DB::transaction(function () use ($user, $nextRank) {
            $user->update([
                'rank_id'          => $nextRank->id,
                'rank_assigned_at' => now(),
            ]);
            app(NotificationAppService::class)->notifyRankUp(
                $user,
                $nextRank
            );
        });
    }


    public function gatherMetricsSinceLastRank(TgUser $user): array
    {
        $since = $user->rank_assigned_at
            ? Carbon::parse($user->rank_assigned_at)
            : Carbon::parse($user->created_at);

        $approved = $user->receipts()
            ->where('status', ReceiptStatus::APPROVED->value)
            ->where('created_at', '>=', $since);

        $scans     = $approved->count();
        $sumSpent  = (float) $approved->sum('total_sum');

        $daysOwned = now()->diffInDays($since) + 1;
        $streak    = (int)min($user->daily_streak, $daysOwned);
        return [
            'scans'       => $scans,
            'sum_spent'   => $sumSpent,
            'streak_days' => $streak,
        ];
    }

    /**
     * Возвращает следующий ранг по порядку или null.
     */
    public function getNextRank(TgUser $user): ?Rank
    {
        $currentOrder = $user->rank?->order ?? 0;

        return Rank::with('conditions')
            ->where('order', '>', $currentOrder)
            ->orderBy('order')
            ->first();
    }

    public function meetsAllConditions(Rank $rank, array $metrics): bool
    {
        foreach ($rank->conditions as $cond) {
            $key   = $cond->key;            // e.g. 'scans'
            $need  = $cond->pivot->value;   // требуемое значение
            $have  = $metrics[$key] ?? 0;
            if ($have < $need) {
                return false;
            }
        }

        return true;
    }

    /**
     * Формирует все данные по рангу:
     * - название текущего и следующего,
     * - условия обоих рангов,
     * - прогресс по каждому условию текущего ранга.
     */
    public function getRankData(TgUser $user): array
    {
        $current = $user->rank;
        $next    = $this->getNextRank($user);

        $condsCur  = $current
            ? $current->conditions->pluck('pivot.value', 'key')->toArray()
            : [];
        $condsNext = $next
            ? $next->conditions->pluck('pivot.value', 'key')->toArray()
            : [];

        $metrics = $this->gatherMetricsSinceLastRank($user);

        return [
            'current_id'        => $current?->id,
            'current_name'        => $current?->name,
            'next_id'           => $next?->id,
            'next_name'           => $next?->name,
            'conditions_current'  => $condsCur,
            'conditions_next'     => $condsNext,
            'progress_current'    => $metrics,
        ];
    }
}
