<?php

namespace Database\Seeders;

use App\Models\Clients\Rank;
use Illuminate\Database\Seeder;

class RanksTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name'=>'Новичок',    'slug'=>'novice',      'coefficient'=>1.0, 'order'=>1],
            ['name'=>'Гастронавт', 'slug'=>'gastronaut',  'coefficient'=>1.2, 'order'=>2],
            ['name'=>'Знаток',     'slug'=>'znatok',      'coefficient'=>1.5, 'order'=>3],
            ['name'=>'Гедонист',   'slug'=>'hedonist',    'coefficient'=>1.8, 'order'=>4],
            ['name'=>'Эстет',      'slug'=>'aesthete',    'coefficient'=>2.0, 'order'=>5],
            ['name'=>'Гурман',     'slug'=>'gourmet',     'coefficient'=>2.5, 'order'=>6],
            ['name'=>'Критик',     'slug'=>'critic',      'coefficient'=>3.5, 'order'=>7],
        ];

        foreach ($data as $r) {
            Rank::updateOrCreate(['slug'=>$r['slug']], $r);
        }
    }
}
