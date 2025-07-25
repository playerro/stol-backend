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
        Schema::create('offer_purchase_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('tg_user_id');
            $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table
                ->foreign('tg_user_id')
                ->references('id')->on('tg_users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_purchase_logs');
    }
};
