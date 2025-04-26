<?php

namespace App\Models;

use App\Enums\ReceiptStatus;
use App\Models\Clients\TgUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Receipt extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected $fillable = [
        'tg_user_id',
        'restaurant_id',
        'qr_raw',
        'fiscal_number',
        'fiscal_document',
        'fiscal_sign',
        'operation_type',
        'total_sum',
        'inn',
        'receipt_at',
        'recognition_data',
        'points',
        'status',
        'organization_name',
        'retail_place',
        'retail_place_address',
    ];

    protected $casts = [
        'qr_raw'          => 'string',
        'fiscal_number'   => 'string',
        'fiscal_document' => 'string',
        'fiscal_sign'     => 'string',
        'operation_type'  => 'integer',
        'total_sum'       => 'decimal:2',
        'inn'             => 'string',
        'receipt_at'      => 'datetime',
        'recognition_data'=> 'array',
        'points'          => 'integer',
        'status'          => ReceiptStatus::class,
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('receipts')
            ->singleFile();
    }

    public function tgUser(): BelongsTo
    {
        return $this->belongsTo(TgUser::class, 'tg_user_id');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class, 'receipt_id');
    }
}
