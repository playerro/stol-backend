<?php

namespace App\Filament\Resources\OfferCategoryResource\Pages;

use App\Filament\Resources\OfferCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOfferCategory extends ViewRecord
{
    protected static string $resource = OfferCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
