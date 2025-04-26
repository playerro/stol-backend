<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'inn'         => $this->inn,
            'name'        => $this->name,
            'rating'      => $this->rating,
            'description' => $this->description,
            'city'        => $this->city,
            'country'     => $this->country,
            'address'     => $this->address,
            'logo_url'    => $this->getFirstMediaUrl('logo'),
            'image'    => $this->getFirstMediaUrl('image'),
        ];
    }
}
