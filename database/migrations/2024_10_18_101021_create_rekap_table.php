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
        Schema::create('rekap', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 30);
            $table->string('kategori', 30);
            $table->string('nama_barang', 50);
            $table->string('seri', 70);
            $table->integer('jumlah');
            $table->enum('satuan', ['pcs', 'roll', 'pack', 'meter', 'unit']);
            $table->integer('rasio')->nullable();
            $table->integer('hasil')->nullable();
            $table->integer('detail_jumlah')->nullable();
            $table->integer('stok_awal');
            $table->integer('in')->nullable();
            $table->integer('out')->nullable();
            $table->string('pop', 12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap');
    }
};
