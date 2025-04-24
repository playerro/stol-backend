<?php

use App\Enums\RankAttributeType;
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
        Schema::create('rank_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Уникальный код атрибута, напр. scans');
            $table->string('label')->comment('Человекочитаемое имя атрибута');
            $table->enum('type', array_map(fn(RankAttributeType $e) => $e->value, RankAttributeType::cases()))
                ->comment('condition = условие, bonus = бонус');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rank_attributes');
    }
};
