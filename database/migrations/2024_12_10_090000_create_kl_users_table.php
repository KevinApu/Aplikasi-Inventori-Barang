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
        Schema::create('kl_users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100);
            $table->string('password');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('pop', 12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kl_users');
    }
};
