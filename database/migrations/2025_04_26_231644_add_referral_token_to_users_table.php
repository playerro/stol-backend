<?php

use App\Models\Clients\TgUser;
use App\Models\User;
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
        foreach (TgUser::all() as $user) {
            do {
                $token = Str::random(5);
            } while (TgUser::where('referral_token', $token)->exists());

            $user->referral_token = $token;
            $user->save();
        }
    }
};
