<?php

namespace App\Models\Support;

use App\Enums\SupportMessageAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportMessage extends Model
{
    protected $fillable = ['ticket_id', 'author', 'message'];

    protected $casts = [
        'author' => SupportMessageAuthor::class,
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }
}
