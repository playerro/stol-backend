<?php

namespace App\Filament\Resources\OfferPurchaseLogResource\Pages;

use App\Filament\Resources\OfferPurchaseLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfferPurchaseLogs extends ListRecords
{
    protected static string $resource = OfferPurchaseLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
