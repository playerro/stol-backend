<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferStore extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = ['name'];

    public function offers()
    {
        return $this->hasMany(Offer::class, 'offer_store_id');
    }
}
