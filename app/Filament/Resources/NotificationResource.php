<?php

namespace App\Filament\Resources;

use App\Enums\NotificationType;
use App\Filament\Resources\NotificationResource\Pages;
use App\Filament\Resources\NotificationResource\RelationManagers;
use App\Models\Notification;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';

    protected static ?string $navigationLabel = 'Лог уведомлений';

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
                Forms\Components\Section::make()->schema([
                    Select::make('tg_user_id')
                        ->label('Telegram-пользователь')
                        ->relationship('tgUser', 'username')
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('type')
                        ->label('Тип')
                        ->options(NotificationType::options())
                        ->required(),

                    TextInput::make('title')
                        ->label('Заголовок')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('subtitle')
                        ->label('Подзаголовок')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('body')
                        ->label('Текст уведомления')
                        ->rows(3),

                    Toggle::make('is_read')
                        ->label('Прочитано')
                        ->inline(false),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgUser.telegram_id')
                    ->url(fn(Notification $record): ?string => $record->tgUser ? TgUserResource::getUrl('view', ['record' => $record->tgUser]) : null)
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(NotificationType $state): string => match ($state) {
                        NotificationType::CHECK_APPROVED => 'success',
                        NotificationType::CHECK_DECLINED     => 'danger',
                        NotificationType::RANK_UP     => 'primary',
                        NotificationType::REFERRAL_CREDIT     => 'gray',
                        NotificationType::PURCHASE     => 'warning',
                    }),
                TextColumn::make('title')->label('Заголовок')->wrap()->sortable(),
                TextColumn::make('subtitle')->label('Подзаголовок')->wrap(),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                ToggleColumn::make('is_read')
                    ->disabled()
                    ->label('Прочитано'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Фильтр по типу')
                    ->options(collect(NotificationType::cases())
                        ->mapWithKeys(fn(NotificationType $t) => [$t->value => ucfirst(str_replace('_', ' ', $t->name))])
                        ->toArray()
                    ),
                SelectFilter::make('is_read')
                    ->label('Статус прочтения')
                    ->options([0 => 'Непрочитанные', 1 => 'Прочитанные']),
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
            'index' => Pages\ListNotifications::route('/'),
            'view' => Pages\ViewNotification::route('/{record}'),
        ];
    }
}
