<?php

namespace App\Clients;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Receipt;
use DomainException;
use Carbon\Carbon;

class ProverkachekaClient
{
    protected string $endpoint;
    protected string $token;
    protected int    $dailyLimit;

    public function __construct()
    {
        $this->endpoint   = config('services.proverkacheka.endpoint');
        $this->token      = config('services.proverkacheka.token');
        $this->dailyLimit = config('services.proverkacheka.daily_limit');
    }

    /**
     * Публичный метод: проверяет лимит, запрашивает, валидирует, маппит.
     *
     * @throws DomainException
     */
    public function recognize(UploadedFile $file): array
    {
        $this->checkDailyLimit();

        $raw = $this->requestRaw($file);

        $this->validateResponseCode($raw['code'] ?? null);

        return $this->mapResponse($raw);
    }

    /**
     * 1) Проверяет дневной лимит по числу распознаваний.
     */
    protected function checkDailyLimit(): void
    {
        $count = Receipt::whereDate('created_at', Carbon::today())->count();

        if ($count >= $this->dailyLimit) {
            throw new DomainException('Превышено кол-во распознаваний чеков в сутки. Попробуйте завтра');
        }
    }

    /**
     * 2) Отправка multipart-запроса и логирование сырого JSON.
     */
    protected function requestRaw(UploadedFile $file): array
    {
        $response = Http::attach(
            'qrfile',
            file_get_contents($file->getPathname()),
            $file->getClientOriginalName()
        )
            ->post($this->endpoint, ['token' => $this->token]);

        //Log::debug('Proverkacheka raw response: '.$response->body());

        return $response->json();
    }

    /**
     * 3) Валидация кода ответа.
     */
    protected function validateResponseCode(?int $code): true
    {
        return match ($code) {
            1 => true,
            0 => throw new DomainException('Чек некорректен'),
            2 => throw new DomainException('Данные чека пока не получены. Попробуйте чуть позже'),
            3 => throw new DomainException('Превышено кол-во запросов. Попробуйте позже.'),
            4 => throw new DomainException('Ожидание перед повторным запросом. Попробуйте позже.'),
            default => throw new DomainException('Не удалось получить данные чека'),
        };
    }

    /**
     * 4) Маппинг полного ответа в нужный формат.
     */
    protected function mapResponse(array $raw): array
    {
        $d = $raw['data']['json'] ?? [];

        return [
            'recognition_data'       => $raw,
            'qr_raw'                 => $raw['request']['qrraw']                   ?? null,
            'fiscal_number'          => (string) ($d['fiscalDriveNumber']        ?? ''),
            'fiscal_document'        => (string) ($d['fiscalDocumentNumber']     ?? ''),
            'fiscal_sign'            => (string) ($d['fiscalSign']               ?? ''),
            'operation_type'         => (int)    ($d['operationType']            ?? 0),
            'sum'                    => (int)    ($d['totalSum']                 ?? 0),
            'userInn'                => (string) ($d['userInn']                  ?? ''),
            'dateTime'               => (string) ($d['dateTime']                 ?? now()->toIso8601String()),
            'items'                  => array_map(function(array $item) {
                return [
                    'name'     => $item['name']     ?? '',
                    'quantity' => $item['quantity'] ?? 1,
                    'price'    => ($item['price'] ?? 0) / 100,
                    'sum'      => ($item['sum']   ?? 0) / 100,
                ];
            }, $d['items'] ?? []),

            'organization_name'      => $d['user']               ?? null,
            'retail_place'           => $d['retailPlace']        ?? null,
            'retail_place_address'   => $d['retailPlaceAddress'] ?? null,
        ];
    }
}
