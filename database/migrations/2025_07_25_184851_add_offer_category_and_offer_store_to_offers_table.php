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
        Schema::table('offers', function (Blueprint $table) {
            $table->foreignId('offer_category_id')
                ->nullable()
                ->after('id');
            $table->foreignId('offer_store_id')
                ->nullable()
                ->after('offer_category_id');
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['offer_category_id', 'offer_store_id']);
        });
    }
};
