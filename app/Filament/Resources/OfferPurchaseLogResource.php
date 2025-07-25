<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferPurchaseLogResource\Pages;
use App\Filament\Resources\OfferPurchaseLogResource\RelationManagers;
use App\Models\OfferPurchaseLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferPurchaseLogResource extends Resource
{
    protected static ?string $model = OfferPurchaseLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $navigationLabel = 'Покупки офферов';

    protected static ?string $navigationGroup = 'Офферы';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Детали покупки')
                    ->schema([
                        Forms\Components\Select::make('tg_user_id')
                            ->relationship('tgUser', 'username')
                            ->label('Пользователь')
                            ->disabled(),

                        Forms\Components\Select::make('offer_id')
                            ->relationship('offer', 'name')
                            ->label('Оффер')
                            ->disabled(),

                        Forms\Components\Placeholder::make('offer_name')
                            ->label('Название оффера')
                            ->content(fn (OfferPurchaseLog $record): ?string => $record->offer?->name),

                        Forms\Components\Placeholder::make('offer_price')
                            ->label('Цена оффера')
                            ->content(fn (OfferPurchaseLog $record): ?string => (string) $record->offer?->price),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgUser.telegram_id')
                    ->url(fn(OfferPurchaseLog $record): ?string => $record->tgUser ? TgUserResource::getUrl('view', ['record' => $record->tgUser]) : null)
                    ->searchable(),
                Tables\Columns\TextColumn::make('offer.name')
                    ->url(fn(OfferPurchaseLog $record): ?string => $record->offer ? OfferResource::getUrl('view', ['record' => $record->offer]) : null)
                    ->searchable(),
                Tables\Columns\TextColumn::make('offer.price')
                    ->label('Цена оффера')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата покупки')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfferPurchaseLogs::route('/'),
            'view' => Pages\ViewOfferPurchaseLog::route('/{record}'),
        ];
    }
}
