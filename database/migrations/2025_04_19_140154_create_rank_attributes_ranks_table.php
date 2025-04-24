<?php

use Database\Seeders\RankAttributesSeeder;
use Database\Seeders\RankAttributeValuesSeeder;
use Database\Seeders\RanksTableSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rank_attribute_rank', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rank_id')
                ->constrained('ranks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('rank_attribute_id')
                ->constrained('rank_attributes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('value')->comment('Значение атрибута для данного ранга');
            $table->timestamps();

            $table->unique(['rank_id','rank_attribute_id']);
        });
        Artisan::call('db:seed', [
            '--class' => RanksTableSeeder::class,
            '--force' => true,
        ]);
        Artisan::call('db:seed', [
            '--class' => RankAttributesSeeder::class,
            '--force' => true,
        ]);
        Artisan::call('db:seed', [
            '--class' => RankAttributeValuesSeeder::class,
            '--force' => true,
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('rank_attribute_rank');
    }
};
