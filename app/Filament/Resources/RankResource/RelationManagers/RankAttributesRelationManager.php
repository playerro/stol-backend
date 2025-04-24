<?php

namespace App\Filament\Resources\RankResource\RelationManagers;

use App\Enums\RankAttributeType;
use App\Models\Clients\RankAttribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RankAttributesRelationManager extends RelationManager
{
    protected static string $relationship = 'rankAttributes';
    protected static ?string $recordTitleAttribute = 'key';
    protected static ?string $title = 'Атрибуты';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->label('Ключ')->sortable(),
                Tables\Columns\TextColumn::make('label')->label('Название')->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(RankAttributeType $state): string => match ($state) {
                        RankAttributeType::CONDITION => 'primary',
                        RankAttributeType::BONUS     => 'success',
                    }),

                Tables\Columns\TextColumn::make('pivot.value')->label('Значение'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form([
                        Forms\Components\Select::make('record_id')
                            ->label('Атрибут')
                            ->options(RankAttribute::pluck('label','id')->toArray())
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('pivot.value')
                            ->label('Значение')
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('pivot.value')
                            ->label('Значение')
                            ->required(),
                    ]),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
