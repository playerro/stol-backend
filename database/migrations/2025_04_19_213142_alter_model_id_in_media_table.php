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
        DB::statement("ALTER TABLE `media` MODIFY `model_id` CHAR(36) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `media` MODIFY `model_id` BIGINT UNSIGNED NOT NULL");
    }
};
