<?php

use App\Enums\ThemeType;
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
        Schema::create('tg_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('rank_id')
                ->default(1)
                ->constrained('ranks')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('telegram_id');
            $table->string('username')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('app_username')->nullable();
            $table->enum('theme', array_column(ThemeType::cases(), 'value'))->default(ThemeType::WhitePink->value);
            $table->integer('visits')->default(0);
            $table->decimal('average_check', 10)->default(0);
            $table->integer('daily_streak')->default(0);
            $table->timestamp('last_visit_at')->nullable();
            $table->integer('points')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_users');
    }
};
