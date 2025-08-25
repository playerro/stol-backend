<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('support_tickets', function (Blueprint $t) {
            $t->id();
            $t->foreignUuid('tg_user_id')->constrained('tg_users')->cascadeOnDelete();
            $t->string('category');
            $t->string('topic')->nullable();
            $t->text('body');
            $t->enum('status', ['new', 'in_progress', 'answered', 'closed'])->default('new');
            $t->timestamp('last_user_reply_at')->nullable();
            $t->timestamp('last_admin_reply_at')->nullable();
            $t->timestamp('closed_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('support_tickets');
    }
};
