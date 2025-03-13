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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50);
            $table->string('pop', 12);
            $table->foreign('pop')->references('pop')->on('kantor_layanan')->onDelete('cascade');
        });


        Schema::create('nama_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang', 70);
            $table->string('pop', 12);
            $table->foreign('pop')->references('pop')->on('kantor_layanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
