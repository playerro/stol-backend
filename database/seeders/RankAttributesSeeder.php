<?php

namespace Database\Seeders;

use App\Enums\RankAttributeType;
use App\Models\Clients\RankAttribute;
use Illuminate\Database\Seeder;

class RankAttributesSeeder extends Seeder
{
    public function run()
    {
        $defs = [
            ['key'=>'scans',               'label'=>'Отсканировано чеков',        'type'=>RankAttributeType::CONDITION],
            ['key'=>'sum_spent',           'label'=>'Суммарно потрачено (₽)',      'type'=>RankAttributeType::CONDITION],
            ['key'=>'streak_days',         'label'=>'Стрик (дней)',               'type'=>RankAttributeType::CONDITION],
            ['key'=>'distinct_cuisines',   'label'=>'Разных кухонь',              'type'=>RankAttributeType::CONDITION],
            ['key'=>'distinct_formats',    'label'=>'Разных форматов обслуживания','type'=>RankAttributeType::CONDITION],
            ['key'=>'events_participated', 'label'=>'Участие в мероприятиях',     'type'=>RankAttributeType::CONDITION],
            ['key'=>'cities_visited',      'label'=>'Городов посещено',           'type'=>RankAttributeType::CONDITION],
            ['key'=>'reviews_written',     'label'=>'Развернутых обзоров',        'type'=>RankAttributeType::CONDITION],
            ['key'=>'reviews_monthly',     'label'=>'Обзоров в месяц',            'type'=>RankAttributeType::CONDITION],
            // бонусы
            ['key'=>'access_events',       'label'=>'Доступ к мероприятиям',      'type'=>RankAttributeType::BONUS],
            ['key'=>'monthly_budget',      'label'=>'Бюджет на месяц (₽)',         'type'=>RankAttributeType::BONUS],
            ['key'=>'discount_percent',    'label'=>'Скидка (%)',                 'type'=>RankAttributeType::BONUS],
            ['key'=>'full_bill_cover',     'label'=>'Оплата счета полностью',      'type'=>RankAttributeType::BONUS],
            ['key'=>'owner_chat',          'label'=>'Чат с владельцами',          'type'=>RankAttributeType::BONUS],
        ];

        foreach ($defs as $d) {
            RankAttribute::updateOrCreate(
                ['key' => $d['key']],
                ['label' => $d['label'], 'type' => $d['type']]
            );
        }
    }
}
