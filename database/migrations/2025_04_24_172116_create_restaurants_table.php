<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('inn', 12)->comment('ИНН организации');
            $table->string('name')->comment('Название');
            $table->decimal('rating', 3, 2)
                ->default(0)
                ->comment('Рейтинг (0.00–5.00)');
            $table->text('description')->nullable()->comment('Описание');
            $table->string('city')->nullable()->comment('Город');
            $table->string('country')->nullable()->comment('Страна');
            $table->text('address')->nullable()->comment('Полный адрес');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->uuid('restaurant_id')
                ->nullable()
                ->after('tg_user_id')
                ->comment('Ссылка на ресторан')
                ->constrained('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('restaurant_id');
        });
        Schema::dropIfExists('restaurants');
    }
};
