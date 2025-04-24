<?php

namespace Database\Seeders;

use App\Models\Clients\Rank;
use App\Models\Clients\RankAttribute;
use Illuminate\Database\Seeder;

class RankAttributeValuesSeeder extends Seeder
{
    public function run()
    {
        // Для каждого slug указываем и условия, и бонусы вместе
        $map = [
            // Rank 2 «Гастронавт» – только условия повышения
            'gastronaut' => [
                'scans'       => 5,
                'sum_spent'   => 10000,
            ],
            // Rank 3 «Знаток»
            'znatok'     => [
                'scans'     => 15,
                'sum_spent' => 15000,
            ],
            // Rank 4 «Гедонист»
            'hedonist'   => [
                'scans'             => 30,
                'streak_days'       => 20,
                'sum_spent'         => 20000,
                'distinct_cuisines' => 3,
                // бонусы
                'access_events'     => 1,
            ],
            // Rank 5 «Эстет»
            'aesthete'   => [
                'scans'               => 50,
                'streak_days'         => 30,
                'sum_spent'           => 35000,
                'distinct_formats'    => 3,
                // бонусы
                'access_events'       => 1,
                'monthly_budget'      => 5000,
            ],
            // Rank 6 «Гурман»
            'gourmet'    => [
                'scans'               => 75,
                'streak_days'         => 50,
                'events_participated' => 1,
                // бонусы
                'access_events'       => 1,
                'monthly_budget'      => 5000,
                'discount_percent'    => 50,
            ],
            // Rank 7 «Критик»
            'critic'     => [
                // условия повышения до 7
                'scans'              => 100,
                'streak_days'        => 80,
                'cities_visited'     => 3,
                'reviews_written'    => 5,
                // условие сохранения Ранга 7
                'reviews_monthly'    => 10,
                // бонусы
                'access_events'      => 1,
                'monthly_budget'     => 5000,
                'full_bill_cover'    => 1,
                'owner_chat'         => 1,
            ],
        ];

        $ranks = Rank::all()->keyBy('slug');
        $defs  = RankAttribute::all()->keyBy('key');

        foreach ($ranks as $slug => $rank) {
            if (isset($map[$slug])) {
                $sync = [];
                foreach ($map[$slug] as $key => $value) {
                    $def = $defs->get($key);
                    if (! $def) {
                        throw new \RuntimeException("Не найдено определение атрибута '{$key}'");
                    }
                    $sync[$def->id] = ['value' => (string)$value];
                }
                $rank->rankAttributes()->sync($sync);
            } else {
                $rank->rankAttributes()->detach();
            }
        }
    }
}
