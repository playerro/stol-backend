<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeaderboardEntryResource;
use App\Http\Resources\LeaderboardResource;
use App\Services\LeaderboardService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


/**
 * @group Рейтинг
 *
 * API для страницы рейтинга
 */
class LeaderboardController extends Controller
{
    public function __construct(protected LeaderboardService $leaderboardService) {}
    /**
     * Список топ‑100 и позиция текущего пользователя
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     *
     * @response 200 {
     *   "data": {
     *     "leaders": [
     *       {
     *         "position": 1,
     *         "avatar": "https://.../1.jpg",
     *         "username": "leader_one",
     *         "points": 1500
     *       },
     *      {
     *         "position": 2,
     *         "avatar": "https://.../1.jpg",
     *         "username": "leader_two",
     *         "points": 1499
     *       },
     *
     *     ],
     *     "user": {
     *       "position": 45,
     *       "avatar": "https://.../45.jpg",
     *       "username": "current_user",
     *       "points": 800
     *     }
     *   }
     * }
     *
     * @response 400 {
     *   "message": "Произошла ошибка",
     *   "error": "Пользователь не найден"
     * }
     */
    public function index(Request $request): JsonResponse|LeaderboardResource
    {
        $userId = $request->input('code');

        try {
            [$leaders, $current] = $this->leaderboardService->getLeaderboardForApi($userId);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Произошла ошибка',
                'error'   => $e->getMessage(),
            ], 400);
        }

        return new LeaderboardResource(compact('leaders', 'current'));
    }
}
