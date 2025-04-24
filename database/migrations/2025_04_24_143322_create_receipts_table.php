<?php

use App\Enums\ReceiptStatus;
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
        Schema::create('receipts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tg_user_id');
            $table->integer('points')->default(0);
            $table->string('status')->default(ReceiptStatus::PENDING->value);
            $table->text('qr_raw')->nullable()->comment('Исходная строка QR-кода');
            $table->string('fiscal_number')->nullable()->comment('ФН из чека');
            $table->string('fiscal_document')->nullable()->comment('ФД из чека');
            $table->string('fiscal_sign')->nullable()->comment('ФП из чека');
            $table->string('operation_type')->nullable()->comment('Тип операции');
            $table->decimal('total_sum', 14, 2)->nullable()->comment('Сумма чека');
            $table->string('inn')->nullable()->comment('ИНН организации');
            $table->dateTime('receipt_at')->nullable()->comment('Дата и время чека');
            $table->timestamps();
            $table
                ->foreign('tg_user_id')
                ->references('id')->on('tg_users')
                ->onDelete('cascade');
        });
        Schema::table('tg_users', function (Blueprint $table) {
            $table->integer('points_remainder')
                ->default(0)
                ->after('points')
                ->comment('Остаток рублей для расчёта баллов');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tg_users', function (Blueprint $table) {
            $table->dropColumn('points_remainder');
        });
        Schema::dropIfExists('receipts');
    }
};
