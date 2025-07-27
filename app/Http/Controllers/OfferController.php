<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferPurchaseRequest;
use App\Models\Offer;
use App\Models\OfferPurchaseLog;
use App\Services\NotificationAppService;
use App\Services\TgUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Офферы
 * API для получения списка, деталей и покупки офферов
 */
class OfferController extends Controller
{
    public function __construct(protected TgUserService $userService,  protected NotificationAppService $notificationService )
    {
    }

    /**
     * Список офферов
     *
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Premium-подписка",
     *       "description": "Месяц доступа к премиум-функциям",
     *       "price": 500,
     *       "image_url": "https://…",
     *       "category": "Подписки",
     *       "store": "Telegram",
     *       "disabled": false
     *     },
     *   ]
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function index(): JsonResponse
    {
        $code = request('code');
        $user = $this->userService->getByUuid($code);
        if (! $user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        $offers = Offer::with(['category','store','media'])
            ->get()
            ->map(fn($offer) => [
                'id'          => $offer->id,
                'name'        => $offer->name,
                'description' => $offer->description,
                'price'       => $offer->price,
                'preview_url'   => $offer->getFirstMediaUrl('preview'),
                'image_url'   => $offer->getFirstMediaUrl('image'),
                'category'    => $offer->category->name,
                'store'       => $offer->store->name,
                'disabled'    => $offer->price > $user->points,
            ]);

        return response()->json(['data' => $offers]);
    }

    /**
     * Детали оффера
     *
     * @queryParam code string required UUID пользователя.
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "Premium-подписка",
     *     "description": "…",
     *     "price": 500,
     *     "image_url": "https://…",
     *     "category": "Подписки",
     *     "store": "Telegram",
     *     "disabled": false
     *   }
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function show(Offer $offer): JsonResponse
    {
        $code = request('code');
        $user = $this->userService->getByUuid($code);
        if (! $user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        $data = [
            'id'          => $offer->id,
            'name'        => $offer->name,
            'description' => $offer->description,
            'price'       => $offer->price,
            'preview_url'   => $offer->getFirstMediaUrl('preview'),
            'image_url'   => $offer->getFirstMediaUrl('image'),
            'category'    => $offer->category->name,
            'store'       => $offer->store->name,
            'disabled'    => $offer->price > $user->points,
        ];

        return response()->json(['data' => $data]);
    }

    /**
     * Покупка оффера
     *
     * @queryParam code string required UUID пользователя.
     *
     * @response 200 {
     *   "message": "Успешно куплено",
     *   "points": 1200,
     *   "purchase_id": 5
     * }
     * @response 422 {
     *   "message": "Недостаточно баллов"
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function purchase(Offer $offer): JsonResponse
    {
        $user = $this->userService->getByUuid(request('code'));
        if (! $user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        if ($offer->price > $user->points) {
            return response()->json(['message' => 'Недостаточно баллов'], 422);
        }

        $user->decrement('points', $offer->price);

        $log = OfferPurchaseLog::create([
            'tg_user_id'  => $user->id,
            'offer_id' => $offer->id,
        ]);

        $this->notificationService->notifyPurchase(
            $user,
            $offer->name
        );

        return response()->json([
            'message'     => 'Успешно куплено',
            'points'     => $user->points,
            'purchase_id' => $log->id,
        ], 200);
    }
}
