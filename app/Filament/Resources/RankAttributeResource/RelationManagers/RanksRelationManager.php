<?php

namespace App\Filament\Resources\RankAttributeResource\RelationManagers;

use App\Models\Clients\Rank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RanksRelationManager extends RelationManager
{
    protected static string $relationship = 'ranks';

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $title = 'Ранги';
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ранг')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Идентификатор'),
                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок'),
                Tables\Columns\TextColumn::make('pivot.value')
                    ->label('Значение'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form([
                        Forms\Components\Select::make('record_id')
                            ->label('Ранг')
                            ->options(Rank::pluck('name','id')->toArray())
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
