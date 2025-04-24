<?php
// app/Services/ReviewService.php

namespace App\Services;

use App\Enums\ReceiptStatus;
use App\Models\Clients\TgUser;
use App\Models\Receipt;
use App\Models\Restaurant;
use App\Models\Review;
use DomainException;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    /**
     * Создаёт отзыв, привязанный к чеку.
     *
     * @param TgUser $user
     * @param string $receiptId
     * @param int    $rating
     * @param string|null $text
     * @return Review
     *
     * @throws DomainException
     */
    public function createReview(TgUser $user, string $receiptId, int $rating, ?string $text): Review
    {
        $receipt = Receipt::with('review')
            ->where('id', $receiptId)
            ->firstOrFail();

        if ($receipt->tg_user_id !== $user->id) {
            throw new DomainException('Этот чек не принадлежит вам.');
        }

        if ($receipt->review) {
            throw new DomainException('Отзыв на этот чек уже существует.');
        }
        $coef = $user->rank?->coefficient ?? 1.0;
        return DB::transaction(function () use ($receipt, $rating, $text, $coef) {
            return Review::create([
                'receipt_id' => $receipt->id,
                'rating'     => $rating,
                'text'       => $text,
                'user_coefficient' => $coef,
            ]);
        });
    }

    public function recalculateRestaurantRating(Restaurant $restaurant): void
    {
        $result = DB::table('reviews')
            ->join('receipts', 'reviews.receipt_id', '=', 'receipts.id')
            ->where('receipts.restaurant_id', $restaurant->id)
            ->where('receipts.status', ReceiptStatus::APPROVED->value)
            ->selectRaw('
                SUM(reviews.rating * reviews.user_coefficient) as weighted_sum,
                SUM(reviews.user_coefficient)             as total_coef
            ')
            ->first();

        $weightedSum = $result->weighted_sum  ?? 0.0;
        $totalCoef   = $result->total_coef    ?? 0.0;

        $newRating = $totalCoef > 0
            ? round($weightedSum / $totalCoef, 2)
            : 0.0;

        $restaurant->update(['rating' => $newRating]);
    }
}
