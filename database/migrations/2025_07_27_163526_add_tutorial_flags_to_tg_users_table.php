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
            $table->boolean('tutorial_completed')->default(false)->after('theme');
            $table->boolean('tutorial_bonus_given')->default(false)->after('tutorial_completed');
            $table->boolean('tutorial_skipped')->default(false)->after('tutorial_bonus_given');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->dropColumn('tutorial_completed');
            $table->dropColumn('tutorial_bonus_given');
            $table->dropColumn('tutorial_skipped');
        });
    }
};
