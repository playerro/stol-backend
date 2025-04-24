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
        Schema::table('tg_users', function (Blueprint $table) {
            $table->string('referral_token', 64)
                ->unique()
                ->after('id');
            $table->uuid('referrer_id')
                ->nullable()
                ->after('referral_token');

            $table->foreign('referrer_id')
                ->references('id')
                ->on('tg_users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->dropForeign(['referrer_id']);
            $table->dropColumn(['referrer_id', 'referral_token']);
        });
    }
};
