<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReviewRequest;
use App\Services\ReviewService;
use App\Services\TgUserService;
use Illuminate\Http\JsonResponse;
use DomainException;
use SebastianBergmann\GlobalState\Exception;

/**
 * @group Отзывы
 * Оставление отзывов на чеки
 */
class ReviewController extends Controller
{
    public function __construct(private readonly ReviewService $service, private readonly TgUserService $userService) {}

    /**
     * Оставить отзыв на чек
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     * @bodyParam receipt_id string required UUID чека. Пример: 019668b1-9b61-72a3-8904-61dcda70cd81
     * @bodyParam rating integer required Оценка от 1 до 5.
     * @bodyParam text string|null Текст отзыва (макс. 2000 символов).
     *
     * @response 200 {
     *   "data": {
     *     "id": "d4f3a2b1-5c6d-7e8f-1234-abcdef567890",
     *     "receipt_id": "019668b1-9b61-72a3-8904-61dcda70cd81",
     *     "rating": 5,
     *     "text": "Отличный ресторан, рекомендую!",
     *     "created_at": "2025-04-27T12:34:56.000000Z"
     *   }
     * }
     *
     * @response 400 {
     *   "message": "Произошла ошибка",
     *   "error": "Чек не принадлежит вам."
     * }
     *
     * @response 500 {
     *   "message": "Произошла ошибка сервера",
     *   "error": "Произошла ошибка сервера"
     * }
     */
    public function store(CreateReviewRequest $request): JsonResponse
    {
        $user      = $this->userService->getByUuid($request->input('code'));
        $data      = $request->validated();

        try {
            $review = $this->service->createReview(
                $user,
                $data['receipt_id'],
                $data['rating'],
                $data['text'] ?? null,
            );

            return response()->json([
                'data' => [
                    'id'         => $review->id,
                    'receipt_id' => $review->receipt_id,
                    'rating'     => $review->rating,
                    'text'       => $review->text,
                    'created_at' => $review->created_at->toIso8601String(),
                ],
            ], 200);

        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error'   => $e->getMessage(),
            ], 400);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'Произошла ошибка сервера',
                'error'   => 'Произошла ошибка сервера',
            ], 500);
        }
    }
}
