<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique()->nullable(); // Unique username
            $table->string('phone')->unique()->nullable();   // Unique phone number
            $table->timestamp('phone_verified_at')->nullable();
            $table->date('birthday')->nullable();
            // Removed age from registration; keep nullable if column exists
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('role')->default('tourist'); // Role column with default
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // IMPORTANT: Change 'email' to 'username' here
        // This makes the password reset tokens table use the username as the identifier.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary(); // CHANGED: from 'email' to 'username'
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};