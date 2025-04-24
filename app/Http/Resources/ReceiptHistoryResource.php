<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptHistoryResource extends JsonResource
{
    public function toArray($request): array
    {
        $restaurant = $this->restaurant;

        return [
            'id'            => $this->id,
            'total_sum'     => $this->total_sum,
            'points'        => $this->points,
            'status'        => $this->status->value,
            'created_at'    => $this->created_at->toIso8601String(),
            'restaurant'    => $restaurant
                ? [
                    'id'          => $restaurant->id,
                    'inn'         => $restaurant->inn,
                    'name'        => $restaurant->name,
                    'rating'      => $restaurant->rating,
                    'description' => $restaurant->description,
                    'city'        => $restaurant->city,
                    'country'     => $restaurant->country,
                    'address'     => $restaurant->address,
                    'image_url'   => $restaurant
                        ->getFirstMediaUrl('image')
                        ?: null,
                ]
                : null,
        ];
    }
}
