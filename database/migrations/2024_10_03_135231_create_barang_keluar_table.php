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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('kode_barang', 50);
            $table->string('kategori', 30);
            $table->string('nama_barang', 50);
            $table->string('seri', 70);
            $table->integer('jumlah');
            $table->string('lokasi', 200);
            $table->string('foto');
            $table->string('nama_customer', 20);
            $table->string('output_by', 20);
            $table->string('keterangan', 50)->nullable();
            $table->string('pop', 12);
            $table->string('qr_code', 100);
            $table->timestamps();
        });
        schema::create('order', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('nama_barang', 50);
            $table->string('seri', 70);
            $table->string('foto');
            $table->integer('stok');
            $table->enum('satuan', ['pcs', 'roll', 'pack','unit']);
            $table->string('lokasi', 70);
            $table->string('username', 20);
            $table->string('pop', 12);
            $table->string('qr_code', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
