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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('telephone')->nullable()->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('can_login')->default(true);

            $table->string('otp')->nullable();
            $table->timestamp('otp_created_at')->nullable();

            $table->string('password_reset_token')->nullable();
            $table->timestamp('password_reset_token_created_at')->nullable();

            $table->string('account_set_token')->nullable();
            $table->timestamp('account_set_token_created_at')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
