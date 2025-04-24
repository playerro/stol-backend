<?php

use Database\Seeders\RanksTableSeeder;
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
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Название ранга');
            $table->string('slug')->unique()->comment('Идентификатор');
            $table->decimal('coefficient', 3, 1)->default(1.0)->comment('Коэффициент оценки');
            $table->unsignedInteger('order')->default(1)->comment('Порядковый номер');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranks');
    }
};
