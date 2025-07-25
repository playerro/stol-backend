<?php

namespace App\Filament\Resources\OfferCategoryResource\Pages;

use App\Filament\Resources\OfferCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOfferCategories extends ListRecords
{
    protected static string $resource = OfferCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
