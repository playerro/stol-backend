<?php

namespace App\Models\Support;

use App\Enums\SupportCategory;
use App\Enums\SupportTicketStatus;
use App\Models\Clients\TgUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    protected $fillable = [
        'tg_user_id', 'category', 'topic', 'body', 'status',
        'last_user_reply_at', 'last_admin_reply_at', 'closed_at'
    ];

    protected $casts = [
        'status'             => SupportTicketStatus::class,
        'category'           => SupportCategory::class,
        'last_user_reply_at'  => 'datetime',
        'last_admin_reply_at' => 'datetime',
        'closed_at'           => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(TgUser::class, 'tg_user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class, 'ticket_id');
    }

    public function scopeAwaitingUser($q)
    {
        return $q->where('status', SupportTicketStatus::Answered->value);
    }
}
