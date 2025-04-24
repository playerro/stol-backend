<?php

namespace App\Filament\Resources;

use App\Enums\ReceiptStatus;
use App\Filament\Resources\ReceiptResource\Pages;
use App\Filament\Resources\ReceiptResource\Pages\EditReceipt;
use App\Filament\Resources\ReceiptResource\RelationManagers;
use App\Models\Receipt;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'Чеки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Чек')->schema([
                    Forms\Components\Select::make('tg_user_id')
                        ->relationship('tgUser', 'id')
                        ->preload()
                        ->searchable()
                        ->required(),
                    Select::make('restaurant_id')
                        ->label('Ресторан')
                        ->required()
                        ->relationship('restaurant', 'name')
                        ->searchable(['inn', 'name'])
                        ->preload()
                        ->suffixAction(
                            Action::make('addRestaurant')
                                ->label('Добавить ресторан')
                                ->icon('heroicon-o-plus')
                                ->button()
                                ->modalHeading('Новый ресторан')
                                ->modalWidth('lg')
                                ->form([
                                    TextInput::make('inn')
                                        ->label('ИНН')
                                        ->required(),
                                    TextInput::make('name')
                                        ->label('Название')
                                        ->required(),
                                    SpatieMediaLibraryFileUpload::make('image')
                                        ->collection('image')
                                        ->label('Картинка анонса'),
                                    TextInput::make('rating')
                                        ->label('Рейтинг (0.00–5.00)')
                                        ->disabled()
                                        ->numeric()
                                        ->step(0.01),
                                    Textarea::make('description')
                                        ->label('Описание')
                                        ->rows(3),
                                    TextInput::make('city')
                                        ->label('Город'),
                                    TextInput::make('country')
                                        ->label('Страна'),
                                    TextInput::make('address')
                                        ->label('Адрес'),
                                ])
                                ->action(function (EditReceipt $livewire, array $data) {
                                    $restaurant = Restaurant::create($data);
                                    $livewire->form->fill([
                                        'restaurant_id' => $restaurant->id,
                                    ]);
                                    Notification::make()
                                        ->title("Ресторан «{$restaurant->name}» создан")
                                        ->success()
                                        ->send();
                                })
                        ),
                    SpatieMediaLibraryFileUpload::make('receipt')
                        ->label('Файл чека')
                        ->collection('receipts')
                        ->downloadable(),
                    Forms\Components\TextInput::make('total_sum')
                        ->label('Сумма, ₽')
                        ->numeric(),
                    Forms\Components\TextInput::make('points')
                        ->label('Баллы (предварительно)')
                        ->required()
                        ->numeric()
                        ->default(0),
                    Select::make('status')
                        ->label('Статус')
                        ->options(ReceiptStatus::class)
                        ->required(),
                    Forms\Components\Textarea::make('qr_raw')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('fiscal_number')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fiscal_document')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('fiscal_sign')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('operation_type')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('inn')
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('receipt_at'),
                ]),
                Section::make('Отзыв')->schema([
                    TextInput::make('review_rating')
                        ->label('Оценка пользователя')
                        ->afterStateHydrated(function (TextInput $component) {
                            $component->state($component->getRecord()->review?->rating);
                        })
                        ->dehydrated(false)
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->maxValue(5)
                        ->helperText('От 1 до 5'),

                    Textarea::make('review_text')
                        ->label('Текст отзыва')
                        ->afterStateHydrated(function (Textarea $component) {
                            $component->state($component->getRecord()->review?->text);
                        })
                        ->rows(3)
                        ->dehydrated(false),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tgUser.telegram_id')
                    ->url(fn(Receipt $record): ?string => $record->tgUser ? TgUserResource::getUrl('view', ['record' => $record->tgUser]) : null)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->alignCenter()
                    ->badge()
                    ->color(fn(ReceiptStatus $state): string => match ($state) {
                        ReceiptStatus::PENDING => 'info',
                        ReceiptStatus::APPROVED => 'success',
                        ReceiptStatus::REJECTED => 'danger',
                        ReceiptStatus::CREATED => 'gray',
                    }),
                Tables\Columns\TextColumn::make('points')
                    ->label('Баллы')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_sum')
                    ->label('Сумма, ₽')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('receipt_at')
                    ->label('Дата покупки')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Загружен')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        ReceiptStatus::PENDING->value  => 'На проверке',
                        ReceiptStatus::APPROVED->value => 'Одобрен',
                        ReceiptStatus::REJECTED->value => 'Отклонён',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'view' => Pages\ViewReceipt::route('/{record}'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $newCount = Receipt::where('status', ReceiptStatus::PENDING)->count();
        return "$newCount Новых";
    }
}
