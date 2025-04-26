<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptRequest;
use App\Http\Resources\ReceiptHistoryResource;
use App\Http\Resources\ReceiptResource;
use App\Services\NotificationService;
use App\Services\ReceiptService;
use App\Services\TgUserService;
use DomainException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * @group Чеки
 * Всё, что связано с чеками ресторанных посещений
 */
class ReceiptController extends Controller
{
    public function __construct(protected ReceiptService      $receiptService,
                                protected TgUserService       $userService,
                                protected NotificationService $notificationService
    )
    {
    }

    /**
     * Загрузка чека
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     *
     * @response 200 {
     * "message": "Чек отправлен на модерацию",
     * "points": 10,
     * "id": 1
     * }
     * @response 422 {
     * "message": "Описание доменной ошибки"
     * }
     * @response 400 {
     * "message": "Произошла ошибка"
     * }
     * @response 404 {
     * "message": "Пользователь не найден"
     * }
     * /
     */
    public function store(StoreReceiptRequest $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->input('code'));
        $file = $request->file('receipt');

        if (!$file) {
            return response()->json([
                'message' => 'Файл не найден',
            ], 404);
        }

        if (!$user) {
            return response()->json([
                'message' => 'Пользователь не найден',
            ], 404);
        }
        try {
            $receipt = $this->receiptService->handleReceipt($user, $file);
            $this->notificationService->notifyAdmins($receipt);
            return response()->json([
                'message' => 'Чек отправлен на модерацию',
                'points' => $receipt->points,
                'total_sum' => $receipt->total_sum,
                'id' => $receipt->id,
            ]);
        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }


    /**
     * История сканированных чеков
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": "019668b1-9b61-72a3-8904-61dcda70cd81",
     *       "total_sum": 1500.20,
     *       "points": 15,
     *       "status": "approved",
     *       "created_at": "2025-04-25T14:12:00Z",
     *       "restaurant": {
     *         "id": "b2d5f7a4-3e56-4c1e-9c3b-123456789abc",
     *         "inn": "7728168971",
     *         "name": "La Pergola",
     *         "rating": "4.75",
     *         "description": "Итальянский ресторан на крыше",
     *         "city": "Москва",
     *         "country": "Россия",
     *         "address": "ул. Примерная, 10",
     *         "image_url": "https://cdn.example.com/announcements/abcd1234.jpg"
     *       }
     *     },
     *
     *   ]
     * }
     * @response 400 {
     *   "message": "Произошла ошибка"
     * }
     */
    public function history(Request $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->input('code'));
        if (!$user) {
            return response()->json([
                'message' => 'Пользователь не найден',
            ], 404);
        }

        try {
            $receipts = $this->receiptService->getHistory($user);
            return response()->json([
                'data' => ReceiptHistoryResource::collection($receipts),
            ], 200);
        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Произошла ошибка',
            ], 400);
        }
    }

    /**
     * История чеков по конкретному ресторану
     *
     * @queryParam code string required UUID пользователя.
     * @queryParam restaurant_id string required UUID ресторана.
     *
     * @response 200 {
     *    "data": [
     *      {
     *        "id": "019668b1-9b61-72a3-8904-61dcda70cd81",
     *        "total_sum": 156.00,
     *        "points": 1,
     *        "status": "approved",
     *        "created_at": "2025-04-24T18:28:00Z",
     *        "restaurant": {
     *          "id": "b2d5f7a4-3e56-4c1e-9c3b-123456789abc",
     *          "inn": "7728168971",
     *          "name": "Mutabor",
     *          "rating": 4.75,
     *          "description": "Современная кухня с авторским подходом",
     *          "city": "Москва",
     *          "country": "Россия",
     *          "address": "ул. Пречистенка, 27",
     *          "image_url": "https://cdn.example.com/announcements/mutabor.jpg"
     *        }
     *      },
     *      {
     *        "id": "f3a1d2c4-6e78-90ab-cdef-1234567890ab",
     *        "total_sum": 348.00,
     *        "points": 3,
     *        "status": "approved",
     *        "created_at": "2025-04-23T15:42:00Z",
     *        "restaurant": {
     *          "id": "b2d5f7a4-3e56-4c1e-9c3b-123456789abc",
     *          "inn": "7728168971",
     *          "name": "Mutabor",
     *          "rating": 4.75,
     *          "description": "Современная кухня с авторским подходом",
     *          "city": "Москва",
     *          "country": "Россия",
     *          "address": "ул. Пречистенка, 27",
     *          "image_url": "https://cdn.example.com/announcements/mutabor.jpg"
     *        }
     *      }
     *    ]
     *  }
     * @response 400 {
     *   "message": "Произошла ошибка",
     *   "error": "Описание ошибки"
     * }
     */
    public function historyByRestaurant(Request $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->input('code'));
        if (!$user) {
            return response()->json([
                'message' => 'Пользователь не найден',
            ], 404);
        }
        $restaurantId = $request->query('restaurant_id');

        try {
            $receipts = $this->receiptService->getHistoryByRestaurant($user, $restaurantId);
        } catch (DomainException $e) {
            return response()->json([
                'message' => 'Произошла ошибка',
                'error'   => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'data' => ReceiptHistoryResource::collection($receipts),
        ]);
    }
}
