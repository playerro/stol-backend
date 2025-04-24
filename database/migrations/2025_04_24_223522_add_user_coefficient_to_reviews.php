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
        Schema::table('reviews', function (Blueprint $table) {
            $table->decimal('user_coefficient', 4, 2)
                ->default(1.00)
                ->after('rating')
                ->comment('Коэффициент ранга пользователя на момент отзыва');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('user_coefficient');
        });
    }
};
