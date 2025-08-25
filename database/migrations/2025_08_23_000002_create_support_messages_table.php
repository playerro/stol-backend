<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('support_messages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('ticket_id')->constrained('support_tickets')->cascadeOnDelete();
            $t->enum('author', ['user', 'admin']);
            $t->text('message');
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('support_messages');
    }
};
