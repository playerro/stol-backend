<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'status'           => $this->status,
            'points'           => $this->points,
            'recognition_data' => $this->recognition_data,
            'created_at'       => $this->created_at->toIso8601String(),
        ];
    }
}
