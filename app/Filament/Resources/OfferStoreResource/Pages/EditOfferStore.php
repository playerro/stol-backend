<?php

namespace App\Filament\Resources\OfferStoreResource\Pages;

use App\Filament\Resources\OfferStoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfferStore extends EditRecord
{
    protected static string $resource = OfferStoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
