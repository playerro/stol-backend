<?php

namespace App\Models;

use App\Models\Clients\TgUser;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferPurchaseLog extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'tg_user_id',
        'offer_id',
    ];

    public function tgUser(): BelongsTo
    {
        return $this->belongsTo(TgUser::class, 'tg_user_id');
    }


    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

}
