<?php

namespace App\Filament\Resources\OfferPurchaseLogResource\Pages;

use App\Filament\Resources\OfferPurchaseLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfferPurchaseLog extends EditRecord
{
    protected static string $resource = OfferPurchaseLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
