<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Services\TgUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Уведомления
 *
 * API для работы со списком уведомлений, подсчётом непрочитанных и пометкой прочтения.
 */
class NotificationController extends Controller
{
    public function __construct(protected TgUserService $userService)
    {
    }

    /**
     * Список уведомлений пользователя
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 10,
     *       "type": "purchase",
     *       "title": "Недавняя покупка",
     *       "subtitle": "Куплен Telegram Premium",
     *       "body": "Telegram Premium на 3 месяца будет начислен завтра.",
     *       "is_read": false,
     *       "created_at": "2025-07-26T12:34:56Z"
     *     },
     *
     *   ],
     *   "meta": {
     *     "current_page": 1,
     *     "last_page": 3,
     *     "per_page": 20,
     *     "total": 45
     *   }
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->query('code'));
        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        $paginator = Notification::where('tg_user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json([
            'data' => NotificationResource::collection($paginator),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ], 200);
    }

    /**
     * Количество непрочитанных уведомлений
     *
     * @queryParam code string required UUID пользователя.
     *
     * @response 200 {
     *   "unread_count": 5
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function unreadCount(Request $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->query('code'));
        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        $count = Notification::where('tg_user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count], 200);
    }

    /**
     * Пометить уведомление как прочитанное
     *
     * @queryParam code string required UUID пользователя.
     *
     * @response 200 {
     *   "message": "OK"
     * }
     * @response 403 {
     *   "message": "Forbidden"
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function markRead(
        Notification                $notification
    ): JsonResponse
    {
        $user = $this->userService->getByUuid(request('code'));
        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        if ($notification->tg_user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'OK'], 200);
    }

}
