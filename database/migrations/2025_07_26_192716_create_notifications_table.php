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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('tg_user_id');
            $table->string('type')->index();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('body')->nullable();
            $table->boolean('is_read')->default(false);

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
        Schema::dropIfExists('notifications');
    }
};
