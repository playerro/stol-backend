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
        Schema::table('receipts', function (Blueprint $table) {

            if (!Schema::hasColumn('receipts', 'recognition_data')) {
                $table->json('recognition_data')->nullable()->after('receipt_at');
            }
            if (!Schema::hasColumn('receipts', 'organization_name')) {
                $table->string('organization_name')->nullable()->after('recognition_data');
            }
            if (!Schema::hasColumn('receipts', 'retail_place')) {
                $table->string('retail_place')->nullable()->after('organization_name');
            }
            if (!Schema::hasColumn('receipts', 'retail_place_address')) {
                $table->string('retail_place_address')->nullable()->after('retail_place');
            }

            $table->unique(
                ['fiscal_number', 'fiscal_document', 'fiscal_sign'],
                'receipts_unique_api'
            );

            $table->index('receipt_at');
            $table->index('inn');
            $table->index('restaurant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropUnique('receipts_unique_api');
            $table->dropIndex(['receipt_at']);
            $table->dropIndex(['inn']);
            $table->dropIndex(['restaurant_id']);
            $table->dropColumn(['organization_name', 'retail_place', 'retail_place_address', 'recognition_data']);
        });
    }
};
