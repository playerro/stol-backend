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
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'Чеки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- Общие поля ---
                Section::make('Общее')
                    ->schema([
                        Select::make('status')
                            ->label('Статус')
                            ->options(ReceiptStatus::class)
                            ->required()
                            ->reactive(),

                        Select::make('tg_user_id')
                            ->label('Пользователь')
                            ->relationship('tgUser', 'id')
                            ->preload()
                            ->searchable()
                            ->required(),

                        SpatieMediaLibraryFileUpload::make('receipt')
                            ->label('Файл чека')
                            ->collection('receipts')
                            ->downloadable(),

                        TextInput::make('total_sum')
                            ->label('Сумма, ₽')
                            ->numeric()
                            ->required(),

                        TextInput::make('points')
                            ->label('Баллы (предварительно)')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(1),

                // --- Секция Ресторан ---
                Section::make('Ресторан')
                    ->schema([
                        Select::make('restaurant_id')
                            ->label('Ресторан')
                            ->relationship('restaurant', 'name')
                            ->searchable(['inn', 'name'])
                            ->preload()
                            ->reactive()
                            ->required(fn(callable $get): bool => $get('status') === ReceiptStatus::APPROVED->value)
                            ->rules([
                                'required_if:status,' . ReceiptStatus::APPROVED->value,
                                'exists:restaurants,id',
                            ])
                            ->suffixAction(
                                Action::make('addRestaurant')
                                    ->label('Добавить ресторан')
                                    ->icon('heroicon-o-plus')
                                    ->button()
                                    ->modalHeading('Новый ресторан')
                                    ->modalWidth('lg')
                                    ->form([
                                        TextInput::make('inn')->label('ИНН')->required(),
                                        TextInput::make('name')->label('Название')->required(),
                                        SpatieMediaLibraryFileUpload::make('image')
                                            ->collection('image')
                                            ->label('Картинка анонса'),
                                        SpatieMediaLibraryFileUpload::make('logo')
                                            ->collection('logo')
                                            ->label('Лого'),
                                        TextInput::make('rating')
                                            ->label('Рейтинг (0.00–5.00)')
                                            ->disabled()
                                            ->numeric()
                                            ->step(0.01),
                                        Textarea::make('description')
                                            ->label('Описание')
                                            ->rows(3),
                                        TextInput::make('city')->label('Город'),
                                        TextInput::make('address')->label('Адрес'),
                                    ])
                                    ->action(function (Set $set, array $data) {
                                        $restaurant = Restaurant::create($data);
                                        // Обновляем только restaurant_id, остальное состояние остается
                                        $set('restaurant_id', $restaurant->id);
                                        Notification::make()
                                            ->title("Ресторан «{$restaurant->name}» создан")
                                            ->success()
                                            ->send();
                                    })
                            ),

                        TextInput::make('organization_name')
                            ->label('Название организации')
                            ->disabled(),

                        TextInput::make('retail_place')
                            ->label('Точка продажи')
                            ->disabled(),

                        TextInput::make('inn')
                            ->label('ИНН')
                            ->disabled(),

                        TextInput::make('retail_place_address')
                            ->columnSpanFull()
                            ->label('Адрес точки')
                            ->disabled(),
                    ])
                    ->columns(2),

                // --- Данные чека (только для чтения) ---
                Section::make('Данные чека')
                    ->schema([
                        TextInput::make('qr_raw')->label('QR Raw')->columnSpanFull()->disabled(),
                        TextInput::make('fiscal_number')->label('Фискальный номер')->disabled(),
                        TextInput::make('fiscal_document')->label('Фискальный документ')->disabled(),
                        TextInput::make('fiscal_sign')->label('Фискальная подпись')->disabled(),
                        TextInput::make('operation_type')->label('Тип операции')->disabled(),
                        DateTimePicker::make('receipt_at')->label('Дата чека')->disabled(),
                    ])
                    ->columns(2),

                // --- Сырые данные API ---
                Section::make('Сырые данные API')
                    ->schema([
                        Textarea::make('recognition_data')
                            ->label('Сырые данные')
                            ->columnSpanFull()
                            ->disabled()
                            ->rows(10)
                            ->afterStateHydrated(function (Textarea $component) {
                                $data = Arr::get($component->getRecord(), 'recognition_data', []);
                                $component->state(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                            })
                            ->dehydrated(false),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // --- Отзыв пользователя ---
                Section::make('Отзыв')
                    ->schema([
                        TextInput::make('review_rating')
                            ->label('Оценка пользователя')
                            ->afterStateHydrated(fn(TextInput $component) => $component->state($component->getRecord()->review?->rating)
                            )
                            ->dehydrated(false)
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(5)
                            ->helperText('От 1 до 5'),

                        Textarea::make('review_text')
                            ->label('Текст отзыва')
                            ->afterStateHydrated(fn(Textarea $component) => $component->state($component->getRecord()->review?->text)
                            )
                            ->rows(3)
                            ->dehydrated(false),
                    ]),
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
