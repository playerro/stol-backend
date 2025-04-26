<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

/**
 * @group Рестораны
 * Всё, что связано с ресторанами
 */
class RestaurantController extends Controller
{
    /**
     * Поиск ресторана по имени, ИНН или адресу
     *
     *
     * @queryParam code string required UUID пользователя. Пример: 123e4567-e89b-12d3-a456-426614174000
     * @queryParam q string required Search query. Минимум 3 символа. Example: sush
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": "uuid",
     *       "inn": "1234567890",
     *       "name": "Суши-Сет",
     *       "rating": "4.50",
     *       "description": "...",
     *       "city": "Москва",
     *       "country": "Россия",
     *       "address": "ул. Пушкина, д.1",
     *       "logo_url": "https://..."
     *     }
     *   ]
     * }
     *
     * @response 200 scenario="No results" {
     *   "data": []
     * }
     *
     * @response 422 scenario="Validation error" {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *     "q": ["The q must be at least 3 characters."]
     *   }
     * }
     */
    public function search(Request $request)
    {
        $q = mb_strtolower($request->input('q'));

        $restaurants = Restaurant::query()
            ->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
            ->orWhere('inn', 'like', "%{$q}%")
            ->orWhereRaw('LOWER(city) LIKE ?', ["%{$q}%"])
            ->orWhereRaw('LOWER(address) LIKE ?', ["%{$q}%"])
            ->limit(20)
            ->get();

        return RestaurantResource::collection($restaurants);
    }
}

