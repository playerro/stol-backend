<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Restaurant extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'inn',
        'name',
        'rating',
        'description',
        'city',
        'country',
        'address',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile();
    }

    /**
     * Все чеки, которые привязаны к этому ресторану
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, 'restaurant_id');
    }
}
