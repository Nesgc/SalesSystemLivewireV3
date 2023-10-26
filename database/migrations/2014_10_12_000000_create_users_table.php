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
            $table->string('name');
            $table->string('phone', 10)->nullable();
            $table->string('email')->unique();
            $table->string('profile', 50)->default('Admin');
            $table->enum('status', ['ACTIVE', 'LOCKED'])->default('ACTIVE');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image', 155)->nullable();
            $table->rememberToken();
            $table->timestamps();
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
