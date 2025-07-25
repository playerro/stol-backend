<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offer_stores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('offer_stores')->insert([
            ['name' => 'ВкусВилл',        'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Золотое Яблоко',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Telegram',        'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_stores');
    }
};
