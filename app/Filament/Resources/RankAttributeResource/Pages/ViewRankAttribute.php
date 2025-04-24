<?php

namespace App\Filament\Resources\RankAttributeResource\Pages;

use App\Filament\Resources\RankAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRankAttribute extends ViewRecord
{
    protected static string $resource = RankAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
