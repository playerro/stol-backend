<?php

namespace App\Filament\Resources;

use App\Enums\RankAttributeType;
use App\Filament\Resources\RankAttributeResource\Pages;
use App\Filament\Resources\RankAttributeResource\RelationManagers;
use App\Filament\Resources\RankAttributeResource\RelationManagers\RanksRelationManager;
use App\Models\Clients\RankAttribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RankAttributeResource extends Resource
{
    protected static ?string $model = RankAttribute::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $recordTitleAttribute = 'key';

    protected static ?string $navigationLabel = 'Атрибуты рангов';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('key')
                        ->label('Ключ')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('label')
                        ->label('Метка')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('type')
                        ->label('Тип')
                        ->options(RankAttributeType::options())
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('label')
                    ->label('Название')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(RankAttributeType $state): string => match ($state) {
                        RankAttributeType::CONDITION => 'primary',
                        RankAttributeType::BONUS     => 'success',
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RanksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRankAttributes::route('/'),
            'create' => Pages\CreateRankAttribute::route('/create'),
            'view' => Pages\ViewRankAttribute::route('/{record}'),
            'edit' => Pages\EditRankAttribute::route('/{record}/edit'),
        ];
    }
}
