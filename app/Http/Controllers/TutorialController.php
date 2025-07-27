<?php

namespace App\Http\Controllers;

use App\Services\TgUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Обучение
 *
 * API обучения
 */
class TutorialController
{
    public function __construct(
        protected TgUserService       $userService,
    ) {}

    /**
     * Статус обучения
     *
     * @queryParam code string required UUID пользователя.
     *
     * @response 200 {
     *   "tutorial_completed": false,
     *   "bonus_available": true
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function status(Request $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->query('code'));
        if (! $user) {
            return response()->json(['message'=>'Пользователь не найден'], 404);
        }

        return response()->json([
            'tutorial_completed' => $user->tutorial_completed,
            'tutorial_bonus_given'    => $user->tutorial_bonus_given,
            'tutorial_skipped'     => $user->tutorial_skipped,
        ], 200);
    }

    /**
     * Завершить обучение
     *
     * @queryParam code string required UUID пользователя.
     *
     * @response 200 {
     *   "message": "Бонус начислен",
     *   "points": 10
     * }
     * @response 400 {
     *   "message": "Бонус уже получен"
     * }
     * @response 404 {
     *   "message": "Пользователь не найден"
     * }
     */
    public function complete(Request $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->query('code'));
        if (! $user) {
            return response()->json(['message'=>'Пользователь не найден'], 404);
        }

        if ($user->tutorial_bonus_given) {
            return response()->json(['message'=>'Бонус уже получен'], 400);
        }

        $user->tutorial_completed    = true;
        $user->tutorial_bonus_given  = true;
        $user->increment('points', 10);
        $user->save();

        return response()->json([
            'message'=>'Бонус начислен',
            'points'=>10,
        ], 200);
    }

    /**
     * Пропустить обучение
     *
     * @queryParam code string required UUID пользователя.
     *
     * @response 200 { "message": "Обучение пропущено" }
     */
    public function skipTutorial(Request $request): JsonResponse
    {
        $user = $this->userService->getByUuid($request->query('code'));
        if (! $user) {
            return response()->json(['message'=>'Пользователь не найден'], 404);
        }

        $user->tutorial_skipped = true;
        $user->save();

        return response()->json(['message'=>'Обучение пропущено'], 200);
    }
}
