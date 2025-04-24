<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'leaders' => LeaderboardEntryResource::collection(
                $this->resource['leaders']
            ),
            'user'    => new LeaderboardEntryResource(
                $this->resource['current']
            ),
        ];
    }
}
