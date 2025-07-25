<?php

namespace App\Filament\Resources\OfferStoreResource\Pages;

use App\Filament\Resources\OfferStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOfferStore extends ViewRecord
{
    protected static string $resource = OfferStoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
