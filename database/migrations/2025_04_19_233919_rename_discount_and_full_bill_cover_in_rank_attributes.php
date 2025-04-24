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
        // Переименовываем ключ для скидки 50% 1 раз/месяц
        DB::table('rank_attributes')
            ->where('key', 'discount_percent')
            ->update([
                'key'   => 'discount_bill_cover_per_month',
                'label' => 'Скидка на счёт (1 раз/месяц)',
            ]);

        // Переименовываем ключ для полной оплаты счёта 1 раз/месяц
        DB::table('rank_attributes')
            ->where('key', 'full_bill_cover')
            ->update([
                'key'   => 'full_bill_cover_per_month',
                'label' => 'Оплата счёта полностью (1 раз/месяц)',
            ]);
    }

    public function down(): void
    {
        // Откат: возвращаем прежние ключи и метки
        DB::table('rank_attributes')
            ->where('key', 'discount_bill_cover_per_month')
            ->update([
                'key'   => 'discount_percent',
                'label' => 'Скидка (%)',
            ]);

        DB::table('rank_attributes')
            ->where('key', 'full_bill_cover_per_month')
            ->update([
                'key'   => 'full_bill_cover',
                'label' => 'Оплата счёта полностью',
            ]);
    }
};
