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
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('receipt_id')
                ->unique()
                ->comment('Связь 1-к-1: один чек — один отзыв');
            $table->tinyInteger('rating')
                ->unsigned()
                ->comment('Оценка 1–5 звезд');
            $table->text('text')
                ->nullable()
                ->comment('Текст отзыва');
            $table->timestamps();

            $table->foreign('receipt_id')
                ->references('id')
                ->on('receipts')
                ->cascadeOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
