<?php

namespace App\Filament\Resources\SupportTicketResource\RelationManagers;

use App\Enums\SupportMessageAuthor;
use App\Models\Support\SupportTicket;
use App\Services\SupportService;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';
    protected static ?string $title = 'Переписка';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message') //изменено
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y H:i')
                    ->label('Время')
                    ->sortable(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Кто')
                    ->formatStateUsing(
                        fn ($state) => $state?->getLabel() ?? $state
                    )
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        SupportMessageAuthor::User->value  => 'primary',
                        SupportMessageAuthor::Admin->value => 'success',
                        default                             => 'gray',
                    }),

                Tables\Columns\TextColumn::make('message') //изменено
                ->label('Сообщение')
                    ->wrap(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('reply')
                    ->label('Ответить пользователю')
                    ->form([
                        Forms\Components\Textarea::make('text')
                            ->label('Текст ответа')
                            ->rows(5)
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        app(SupportService::class)
                            ->appendAdminMessage($this->getOwnerRecord(), $data['text']);
                    })
                    ->modalHeading('Ответ пользователю'),
            ])
            ->defaultSort('created_at', 'asc');
    }
}
