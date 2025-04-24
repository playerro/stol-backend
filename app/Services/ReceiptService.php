<?php

namespace App\Services;

use App\Enums\ReceiptStatus;
use App\Models\Clients\TgUser;
use App\Models\Receipt;
use DomainException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Str;

class ReceiptService
{
    private const MAX_FILE_SIZE = 20 * 1024 * 1024;
    private array $allowedExtensions = ['jpg','jpeg','png','pdf','heic','tiff'];
    private const RUBLES_PER_POINT = 100;
    public function handleReceipt(TgUser $user, UploadedFile $file): Receipt
    {
        $this->validateFile($file);

        $data = $this->getReceiptData($file);
        $rubles       = $this->extractRubles($data);
        $prelimPoints = $this->calculatePrelimPoints($rubles);

        return DB::transaction(function() use ($user, $file, $data, $rubles, $prelimPoints) {
            /** @var Receipt $receipt */
            $receipt = Receipt::create([
                'tg_user_id' => $user->id,
                'status'     => ReceiptStatus::CREATED,
            ]);

            $receipt->addMedia($file)->toMediaCollection('receipts');

            $receipt->update([
                'qr_raw'           => $data['qr_raw'],
                'fiscal_number'    => $data['fiscal_number'],
                'fiscal_document'  => $data['fiscal_document'],
                'fiscal_sign'      => $data['fiscal_sign'],
                'operation_type'   => $data['operation_type'],
                'total_sum'        => $rubles,
                'inn'              => $data['userInn'],
                'receipt_at'       => $data['dateTime'],
                'points'           => $prelimPoints,
                'status'           => ReceiptStatus::PENDING,
            ]);

            return $receipt;
        });
    }

    public function getHistory(TgUser $user)
    {
        return $user
            ->receipts()
            ->with('restaurant')
            ->where('status', ReceiptStatus::APPROVED->value)
            ->orderByDesc('created_at')
            ->get();
    }

    public function applyPointsOnApproval(Receipt $receipt): int
    {
        if ($receipt->status->value !== ReceiptStatus::APPROVED->value) {
            throw new DomainException('Чек не в статусе одобрен.');
        }

        $user = $receipt->tgUser;

        return DB::transaction(function () use ($user, $receipt) {
            $combined      = $user->points_remainder + $receipt->total_sum;
            $awardPoints   = intdiv((int) floor($combined), self::RUBLES_PER_POINT);
            $newRemainder  = $combined - $awardPoints * self::RUBLES_PER_POINT;

            $user->increment('points', $awardPoints);
            $user->points_remainder = $newRemainder;
            $user->increment('visits');
            $totalSumAll = $user
                ->receipts()
                ->where('status', ReceiptStatus::APPROVED->value)
                ->sum('total_sum');
            $user->average_check = $user->visits
                ? round($totalSumAll / $user->visits, 2)
                : 0;

            $user->save();

            return $awardPoints;
        });
    }

    public function determineFavorite(TgUser $user): ?array
    {
        /** @var Collection $approved */
        $approved = $user->receipts
            ->where('status', ReceiptStatus::APPROVED->value)
            ->filter(fn($r) => $r->restaurant !== null);

        if ($approved->isEmpty()) {
            return null;
        }

        $grouped = $approved->groupBy(fn($r) => $r->restaurant->id);

        $best = $grouped
            ->map(fn($group) => [
                'restaurant'  => $group->first()->restaurant,
                'checks_count'=> $group->count(),
                'sum_spent'   => $group->sum('total_sum'),
            ])
            ->sortByDesc('checks_count')
            ->first();

        return [
            'id'           => $best['restaurant']->id,
            'name'         => $best['restaurant']->name,
            'description' => $best['restaurant']->description,
            'city' => $best['restaurant']->city,
            'country' => $best['restaurant']->country,
            'address' => $best['restaurant']->address,
            'image_url'    => $best['restaurant']->getFirstMediaUrl('image')
                ?: null,
                'rating'       => $best['restaurant']->rating,
            'checks_count' => $best['checks_count'],
            'sum_spent'    => round((float) $best['sum_spent'], 2),
        ];
    }

    public function determineRecent(TgUser $user): ?array
    {
        /** @var Receipt|null $last */
        $last = $user->receipts
            ->where('status', ReceiptStatus::APPROVED->value)
            ->sortByDesc('created_at')
            ->first();

        if (! $last || ! $last->restaurant) {
            return null;
        }

        $restaurant = $last->restaurant;

        return [
            'label'     => 'Недавнее',
            'id'        => $restaurant->id,
            'name'      => $restaurant->name,
            'image_url' => $restaurant->getFirstMediaUrl('image')
                ?: null,
            'rating'    => $restaurant->rating,
            'points'    => $last->points,
            'description' => $restaurant->description,
            'city' => $restaurant->city,
            'country' => $restaurant->country,
            'address' => $restaurant->address,
        ];
    }

    public function getHistoryByRestaurant(TgUser $user, string $restaurantId): Collection
    {
        return $user->receipts()
            ->with('restaurant')
            ->where('restaurant_id', $restaurantId)
            ->orderByDesc('created_at')
            ->get();
    }

    private function validateFile(UploadedFile $file): void
    {
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new DomainException('Файл слишком большой (максимум 20 МБ).');
        }
        $ext = strtolower($file->getClientOriginalExtension());
        if (! in_array($ext, $this->allowedExtensions, true)) {
            throw new DomainException("Неподдерживаемый формат файла: {$ext}.");
        }
    }

    private function getReceiptData(UploadedFile $file): array
    {
        $totalRub = random_int(500, 5000); // 5.00–50.00 ₽
        $nowIso   = now()->toIso8601String();

        return [
            'qr_raw'          => 'stub://'.Str::uuid(),
            'fiscal_number'   => (string) random_int(1e7, 1e8 - 1),
            'fiscal_document' => (string) random_int(1, 9999),
            'fiscal_sign'     => (string) random_int(1e9, 1e10 - 1),
            'operation_type'  => 1,
            'sum'             => (int) ($totalRub * 100),
            'userInn'         => '0000000000',
            'dateTime'        => $nowIso,
            'items'           => [
                [
                    'name'     => 'Товар-заглушка',
                    'quantity' => 1,
                    'price'    => $totalRub,
                    'sum'      => $totalRub,
                ],
            ],
        ];
    }

    private function extractRubles(array $data): float
    {
        if (empty($data['sum']) || ! is_int($data['sum'])) {
            throw new DomainException('Не удалось определить сумму чека.');
        }

        return $data['sum'] / 100;
    }

    private function calculatePrelimPoints(float $rubles): int
    {
        return intdiv((int) floor($rubles), self::RUBLES_PER_POINT);
    }
}
