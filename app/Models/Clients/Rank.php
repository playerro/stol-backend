<?php

namespace App\Models\Clients;

use App\Enums\RankAttributeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rank extends Model
{
    protected $fillable = ['name','slug','coefficient','order'];
    protected $casts = ['coefficient'=>'float','order'=>'integer'];

    public function rankAttributes(): BelongsToMany
    {
        return $this
            ->belongsToMany(RankAttribute::class, 'rank_attribute_rank')
            ->withPivot('value')
            ->withTimestamps();
    }

    /**
     * Только условия (type = condition).
     */
    public function conditions()
    {
        return $this->rankAttributes()
            ->where('type', RankAttributeType::CONDITION->value);
    }

    /**
     * Только бонусы (type = bonus).
     */
    public function bonuses()
    {
        return $this->rankAttributes()
            ->where('type', RankAttributeType::BONUS->value);
    }

    public function tgUsers()
    {
        return $this->hasMany(TgUser::class);
    }
}
