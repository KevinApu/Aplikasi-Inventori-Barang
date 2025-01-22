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
        Schema::create('barang_rusak', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('kode_barang', 30);
            $table->string('kategori', 30);
            $table->string('nama_barang', 50);
            $table->string('seri', 70);
            $table->integer('jumlah');
            $table->string('input_by', 20);
            $table->string('foto');
            $table->string('kondisi', 50);
            $table->string('penyebab', 50);
            $table->string('pop', 12);
            $table->string('qr_code', 255)->nullable();
            $table->string('status', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_rusak');
    }
};
