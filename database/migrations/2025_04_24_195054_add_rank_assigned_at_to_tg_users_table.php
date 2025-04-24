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
        Schema::table('tg_users', function (Blueprint $table) {
            $table->timestamp('rank_assigned_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'))
                ->after('rank_id')
                ->comment('Дата и время присвоения текущего ранга');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->dropColumn([
                'rank_assigned_at',
            ]);
        });
    }
};
