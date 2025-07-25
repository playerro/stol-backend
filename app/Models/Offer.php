<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements HasMedia
{
    use HasFactory, HasTimestamps, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
        $this->addMediaCollection('preview')->singleFile();
    }

    public function category()
    {
        return $this->belongsTo(OfferCategory::class, 'offer_category_id');
    }

    public function store()
    {
        return $this->belongsTo(OfferStore::class, 'offer_store_id');
    }
}
