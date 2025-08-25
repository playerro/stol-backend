<?php

namespace App\Telegram\Support;

use App\Enums\SupportCategory;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SupportKeyboards
{
    // ===== NEW: возвращает список опций для темы ===== //изменено
    public static function topicsOptions(SupportCategory $category): array //изменено
    {
        $map = [
            SupportCategory::Points->value   => ['Баллы не начислились','Баллы пропали','Другое'],
            SupportCategory::Purchase->value => ['Не пришел товар','Ошибка при оплате','Товар не работает','Другое'],
            SupportCategory::Scan->value     => ['Камера не открывается','QR не считывается','Ошибка сканирования','Другое'],
            SupportCategory::Bug->value      => ['Приложение вылетает','Не работает кнопка','Неправильное отображение данных','Другое'], //изменено
            SupportCategory::Rank->value     => ['Ранг не обновился','Ранг сбросился','Неверный ранг','Другое'],
            SupportCategory::Cooperation->value => ['Реклама','Совместный проект','Программа лояльности','B2B сотрудничество','Другое'],
            SupportCategory::Other->value       => ['Вопрос по функционалу','Обратная связь','Другое'],
        ];

        return $map[$category->value] ?? ['Другое'];
    }

    public static function categories(): InlineKeyboardMarkup
    {
        $pairs = [
            [SupportCategory::Points,    SupportCategory::Purchase],
            [SupportCategory::Scan,      SupportCategory::Bug],
            [SupportCategory::Rank,      SupportCategory::Cooperation],
            [SupportCategory::Other,     null], // справа «Отмена»
        ];

        $kb = InlineKeyboardMarkup::make();
        foreach ($pairs as [$left, $right]) {
            $row = [];
            if ($left) {
                $row[] = InlineKeyboardButton::make(
                    text: $left->getLabel(),
                    callback_data: 'support.cat.'.$left->value
                );
            }
            if ($right instanceof SupportCategory) {
                $row[] = InlineKeyboardButton::make(
                    text: $right->getLabel(),
                    callback_data: 'support.cat.'.$right->value
                );
            } else {
                $row[] = InlineKeyboardButton::make(text: 'Отмена', callback_data: 'support.cancel');
            }
            $kb->addRow(...$row);
        }
        return $kb;
    }

    public static function topics(SupportCategory $category): InlineKeyboardMarkup
    {
        $options = self::topicsOptions($category); //изменено

        $kb = InlineKeyboardMarkup::make();
        foreach ($options as $i => $label) { //изменено
            // короткий callback: support.topic.{index}
            $kb->addRow(
                InlineKeyboardButton::make(
                    text: $label,
                    callback_data: 'support.topic.'.$i //изменено
                )
            );
        }
        $kb->addRow(InlineKeyboardButton::make(text: 'Назад', callback_data: 'support.back.root'));

        return $kb;
    }

    public static function confirm(): InlineKeyboardMarkup
    {
        return InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make(text: 'Отправить', callback_data: 'support.send'),
                InlineKeyboardButton::make(text: 'Назад', callback_data: 'support.back.topic'),
            );
    }
}
