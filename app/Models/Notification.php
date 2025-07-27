<?php

namespace App\Models;

use App\Enums\NotificationType;
use App\Models\Clients\TgUser;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory, HasTimestamps;

    protected $fillable = [
        'tg_user_id',
        'type',
        'title',
        'subtitle',
        'body',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'type'    => NotificationType::class,
    ];

    public function tgUser(): BelongsTo
    {
        return $this->belongsTo(TgUser::class);
    }
}
