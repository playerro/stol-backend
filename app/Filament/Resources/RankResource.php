<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RankResource\Pages;
use App\Filament\Resources\RankResource\RelationManagers;
use App\Filament\Resources\RankResource\RelationManagers\RankAttributesRelationManager;
use App\Models\Clients\Rank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RankResource extends Resource
{
    protected static ?string $model = Rank::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Ранги';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Название')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->label('Идентификатор')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('coefficient')
                        ->label('Коэффициент')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('order')
                        ->label('Порядок')
                        ->numeric()
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')->label('№')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Идентификатор')->sortable(),
                Tables\Columns\TextColumn::make('coefficient')->label('Коэффициент')->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RankAttributesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRanks::route('/'),
            'create' => Pages\CreateRank::route('/create'),
            'view' => Pages\ViewRank::route('/{record}'),
            'edit' => Pages\EditRank::route('/{record}/edit'),
        ];
    }
}
