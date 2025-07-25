<?php

namespace App\Filament\Resources\OfferCategoryResource\Pages;

use App\Filament\Resources\OfferCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfferCategory extends EditRecord
{
    protected static string $resource = OfferCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
