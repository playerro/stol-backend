<?php

namespace App\Filament\Resources;

use App\Enums\SupportTicketStatus;
use App\Filament\Resources\SupportTicketResource\Pages;
use App\Filament\Resources\SupportTicketResource\RelationManagers\MessagesRelationManager;
use App\Models\Support\SupportTicket;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static ?string $navigationGroup = 'Поддержка';
    protected static ?string $navigationIcon  = 'heroicon-o-envelope';
    protected static ?string $modelLabel      = 'Тикет';
    protected static ?string $pluralModelLabel= 'Тикеты';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Section::make('Карточка тикета')->schema([
                Forms\Components\TextInput::make('id')->label('ID')->disabled()->dehydrated(false),
                Forms\Components\TextInput::make('user.username')->label('Пользователь')->disabled()->dehydrated(false),
                Forms\Components\TextInput::make('category')->label('Категория')->disabled()->dehydrated(false),
                Forms\Components\TextInput::make('topic')->label('Тема')->disabled()->dehydrated(false),
                Forms\Components\Textarea::make('body')->label('Сообщение')->rows(6)->disabled()->dehydrated(false),
                Forms\Components\Select::make('status')
                    ->label('Статус')
                    ->options(collect(SupportTicketStatus::cases())
                        ->mapWithKeys(fn($c) => [$c->value => $c->getLabel()])
                        ->toArray())
                    ->native(false),
            ])->columns(2),

            Forms\Components\Section::make('Ответ пользователю')->schema([
                Forms\Components\Textarea::make('answer')
                    ->label('Текст ответа')
                    ->helperText('При сохранении отправит ответ в Telegram и переведёт тикет в статус "Ответ отправлен".')
                    ->rows(6),
            ]),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('user.username')->label('Пользователь')->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Категория')->searchable(),
                Tables\Columns\TextColumn::make('topic')->label('Тема')->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->formatStateUsing(
                        fn ($state) => $state?->getLabel() ?? $state
                    )
                    ->badge() //изменено
                    ->color(fn ($state) => match ($state) { //изменено
                        SupportTicketStatus::New     => 'warning',
                        SupportTicketStatus::Answered => 'info',
                        SupportTicketStatus::Closed   => 'success',
                        default                       => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Создан')->since()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Обновлён')->since()->toggleable()->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(SupportTicketStatus::cases())->mapWithKeys(
                        fn($c) => [$c->value => $c->getLabel()]
                    )->toArray()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupportTickets::route('/'),
            'view'  => Pages\ViewSupportTicket::route('/{record}'),
            'edit'  => Pages\EditSupportTicket::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            MessagesRelationManager::class,
        ];
    }
}
