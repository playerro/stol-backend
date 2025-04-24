<?php

namespace App\Http\Middleware;

use App\Services\TgUserService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserFromTg
{
    public function __construct(protected TgUserService $userService){}

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uuid = $request->input('code');

        if ($uuid && $this->userService->getByUuid($uuid)) {
            return $next($request);
        }
        return new JsonResponse(['message'=> 'Пользователь не найден', 'error' => 'Пользователь не найден'], 404);
    }
}
