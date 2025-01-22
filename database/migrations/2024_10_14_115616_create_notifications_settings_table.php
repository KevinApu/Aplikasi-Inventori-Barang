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
        Schema::create('notifications_settings', function (Blueprint $table) {
            $table->id('id');
            $table->integer('roll')->default(5);
            $table->integer('pack')->default(5);
            $table->integer('unit')->default(5);
            $table->integer('pcs')->default(5);
            $table->string('pop', 12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_settings');
    }
};
