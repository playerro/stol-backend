<?php

namespace App\Filament\Resources;

use App\Enums\ThemeType;
use App\Filament\Resources\TgUserResource\Pages;
use App\Filament\Resources\TgUserResource\RelationManagers;
use App\Models\Clients\TgUser;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TgUserResource extends Resource
{
    protected static ?string $model = TgUser::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $recordTitleAttribute = 'username';

    protected static ?string $navigationLabel = 'Пользователи';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('telegram_id')
                        ->label('Telegram ID')
                        ->required()
                        ->unique(table: TgUser::class, ignoreRecord: true),
                    Forms\Components\TextInput::make('username')
                        ->label('Username')
                        ->nullable(),
                    Forms\Components\TextInput::make('first_name')
                        ->label('Имя')
                        ->nullable(),
                    Forms\Components\TextInput::make('last_name')
                        ->label('Фамилия')
                        ->nullable(),
                    Forms\Components\TextInput::make('app_username')
                        ->label('App Username')
                        ->nullable(),
                    Forms\Components\Select::make('theme')
                        ->label('Тема')
                        ->options(
                            collect(ThemeType::cases())
                                ->mapWithKeys(fn(ThemeType $t) => [$t->value => $t->value])
                                ->toArray()
                        )
                        ->default(ThemeType::WhitePink->value),
                    Forms\Components\TextInput::make('visits')
                        ->label('Визиты')
                        ->numeric()
                        ->default(0),
                    Forms\Components\TextInput::make('average_check')
                        ->label('Средний чек')
                        ->numeric()
                        ->default(0),
                    Forms\Components\TextInput::make('daily_streak')
                        ->label('Стрик')
                        ->numeric()
                        ->default(0),
                    DateTimePicker::make('last_visit_at')
                        ->label('Последний визит'),
                    Forms\Components\Select::make('rank_id')
                        ->label('Ранг')
                        ->relationship('rank', 'name')
                        ->searchable(),
                    Forms\Components\TextInput::make('points')
                        ->label('Баллы')
                        ->numeric()
                        ->default(0),
                    SpatieMediaLibraryFileUpload::make('avatars')
                        ->collection('avatars')
                        ->label('Аватар'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('username')
                    ->label('Username')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                SpatieMediaLibraryImageColumn::make('avatars')
                    ->label('Аватар')
                    ->collection('avatars')
                    ->conversion('thumb')
                    ->circular(),
                TextColumn::make('telegram_id')
                    ->label('Telegram ID')
                    ->sortable(),
                TextColumn::make('rank.name')
                    ->label('Ранг')
                    ->sortable(),
                TextColumn::make('visits')
                    ->label('Визиты')
                    ->sortable(),
                TextColumn::make('last_visit_at')
                    ->label('Последний визит')
                    ->dateTime(),
                TextColumn::make('points')
                    ->label('Баллы')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
                Tables\Actions\RestoreAction::make()->label(''),
                Tables\Actions\ForceDeleteAction::make()->label(''),
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
            'index' => Pages\ListTgUsers::route('/'),
            'create' => Pages\CreateTgUser::route('/create'),
            'view' => Pages\ViewTgUser::route('/{record}'),
            'edit' => Pages\EditTgUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
