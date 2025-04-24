<?php

namespace App\Filament\Resources\RankAttributeResource\Pages;

use App\Filament\Resources\RankAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRankAttributes extends ListRecords
{
    protected static string $resource = RankAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
