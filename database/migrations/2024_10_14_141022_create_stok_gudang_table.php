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
        Schema::create('stok_gudang', function (Blueprint $table) {
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
            $table->string('lokasi', 70);
            $table->string('foto')->nullable();
            $table->string('input_by', 20);
            $table->string('keterangan', 50)->nullable();
            $table->string('pop', 12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_gudang');
    }
};
