<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardEntryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'position' => $this->position,
            'avatar' => $this->getFirstMediaUrl('avatars') ?: null,
            'username' => $this->app_username
                ?: ($this->first_name ?: 'Неизвестный'),
            'points' => $this->points,
        ];
    }
}
