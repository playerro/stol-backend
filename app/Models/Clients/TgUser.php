<?php

namespace App\Models\Clients;

use App\Enums\ThemeType;
use App\Models\Receipt;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Str;

class TgUser  extends Model implements HasMedia
{
    use HasFactory, Notifiable, HasTimestamps, SoftDeletes, HasUuids, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'telegram_id',
        'username',
        'first_name',
        'last_name',
        'photo_url',
        'app_username',
        'theme',
        'visits',
        'average_check',
        'daily_streak',
        'last_visit_at',
        'rank_id',
        'points',
        'referral_token',
        'referrer_id',
        'points_remainder',
        'rank_assigned_at'
    ];

    protected $casts = [
        'theme'          => ThemeType::class,
        'visits'         => 'integer',
        'average_check'  => 'decimal:2',
        'daily_streak'   => 'integer',
        'last_visit_at'  => 'datetime',
        'rank_id'        => 'integer',
        'points'         => 'integer',
        'points_remainder' => 'integer',
    ];

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->singleFile();
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(self::class, 'referrer_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(self::class, 'referrer_id');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, 'tg_user_id');
    }

    protected static function booted(): void
    {
        static::creating(function (self $user) {
            do {
                $token = Str::random(5);
            } while (self::where('referral_token', $token)->exists());

            $user->referral_token = $token;
        });
    }

    public function getReferralLinkAttribute(): string
    {
        $bot    = config('app.telegram.bot_username');
        return "https://t.me/{$bot}?start={$this->referral_token}";
    }

}
