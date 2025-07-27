<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\TgUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Пользователи
 *
 * API пользователей
 */
class UserController extends Controller
{
    public function __construct(protected TgUserService $userService){}

    /**
     * Информация о пользователе
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     *
     * @response 200 {
     *    "data": {
     *      "avatar": "https://cdn.example.com/avatars/abcd1234.jpg",
     *      "username": "ivan_petrov",
     *      "points": 245,
     *      "points_remainder": 56,
     *      "daily_streak": 5,
     *      "visits": 42,
     *      "average_check": "123.45",
     *      "telegram_id": 987654321,
     *      "first_name": "Иван",
     *      "last_name": "Петров",
     *      "theme": "dark",
     *      "created_at": "2024-12-01T14:23:45.000000Z",
     *      "rank": {
     *        "current": "Silver",
     *        "current_id": "1",
     *        "next": "Gold",
     *        "next_id": "2",
     *        "conditions_current": { "scans": 10, "sum_spent": 5000, "streak_days": 7 },
     *        "conditions_next":    { "scans": 15, "sum_spent": 15000, "streak_days": 15 },
     *        "progress_current":   { "scans": 3,  "sum_spent": 1200.50, "streak_days": 2 }
     *      },
     *      "favorite": {
     *        "label": "Любимое",
     *        "id": "b2d5f7a4-3e56-4c1e-9c3b-123456789abc",
     *        "name": "La Pergola",
     *        "image_url": "https://cdn.example.com/announcements/abcd1234.jpg",
     *        "rating": 4.75,
     *        "checks_count": 5,
     *        "sum_spent": 2345.67
     *      },
     *      "recent": {
     *        "label": "Недавнее",
     *        "id": "b2d5f7a4-3e56-4c1e-9c3b-123456789abc",
     *        "name": "La Pergola",
     *        "image_url": "https://cdn.example.com/announcements/abcd1234.jpg",
     *        "rating": 15,
     *        "points": 15
     *      },
     *      "referral_link": "https://t.me/YourBot?start=refToken123"
     *    }
     *
     * @response 400 {
     *    "message":"Произошла ошибка",
     *    "error":"Подробное сообщение об ошибке"
     *  }
     *
     * @response 400 {
     *    "message": "Произошла ошибка",
     *    "error": "Ошибка"
     *  }
     */
    public function show(Request $request): JsonResponse|UserResource
    {
        $userId = $request->input('code');

        try {
            $user = $this->userService->getUserForApi($userId);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => 'Произошла ошибка',
                'error'   => $exception->getMessage(),
            ], 400);
        }

        return new UserResource($user);
    }

    /**
     * Обновить профиль
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     *
     * @response 200 {
     *   "data": {
     *     "avatar": "https://…",
     *     "username": "Paul",
     *     "points": 245,
     *     "daily_streak": 5,
     *     "telegram_id": 987654321,
     *     "first_name": "Иван",
     *     "last_name": "Петров",
     *     "theme": "gray-brown",
     *     "visits": 42,
     *     "average_check": "123.45",
     *     "created_at": "2024-12-01T14:23:45.000000Z",
     *     "rank": {
     *       "current": "Bronze",
     *       "next": null,
     *       "progress": 0
     *     }
     *   }
     * }
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "theme": ["Тема должна быть одной из: white-pink, gray-brown, gray-black"]
     *   }
     * }
     * @response 400 {
     *   "message": "Произошла ошибка",
     *   "error": "Ошибка"
     * }
     */
    public function update(UpdateUserRequest $request): JsonResponse|UserResource
    {
        $userId = $request->input('code');
        $data   = $request->only(['username', 'theme']);

        try {
            $user = $this->userService->updateProfile($userId, $data);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Произошла ошибка',
                'error'   => $exception->getMessage(),
            ], 400);
        }

        return new UserResource($user);
    }
}
