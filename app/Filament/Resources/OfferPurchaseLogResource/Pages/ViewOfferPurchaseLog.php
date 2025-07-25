<?php

namespace App\Filament\Resources\OfferPurchaseLogResource\Pages;

use App\Filament\Resources\OfferPurchaseLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOfferPurchaseLog extends ViewRecord
{
    protected static string $resource = OfferPurchaseLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
