<?php

namespace App\Filament\Resources\RankAttributeResource\Pages;

use App\Filament\Resources\RankAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRankAttribute extends EditRecord
{
    protected static string $resource = RankAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
