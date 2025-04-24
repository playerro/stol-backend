<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'reviews';

    protected $fillable = [
        'receipt_id',
        'rating',
        'text',
        'user_coefficient'
    ];

    protected $casts = [
        'rating' => 'integer',
        'user_coefficient' => 'decimal'
    ];

    /**
     * Чек, к которому прикреплён отзыв.
     */
    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class, 'receipt_id');
    }

    /**
     * Пользователь (через чек).
     */
    public function tgUser(): BelongsTo
    {
        return $this->receipt->tgUser();
    }
}
