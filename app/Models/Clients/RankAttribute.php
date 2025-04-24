<?php

namespace App\Models\Clients;

use App\Enums\RankAttributeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RankAttribute extends Model
{
    protected $fillable = ['key','label','type'];

    protected $casts = [
        'type' => RankAttributeType::class,
    ];

    /**
     * Связь с Rank через pivot rank_attribute_rank.
     */
    public function ranks(): BelongsToMany
    {
        return $this
            ->belongsToMany(Rank::class, 'rank_attribute_rank')
            ->withPivot('value')
            ->withTimestamps();
    }
}
