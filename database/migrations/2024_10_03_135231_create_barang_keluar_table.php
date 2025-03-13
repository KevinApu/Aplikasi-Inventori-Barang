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
            $table->id();
            $table->integer('jumlah');
            $table->string('lokasi', 200);
            $table->string('nama_customer', 20);
            $table->string('output_by', 20);
            $table->string('keterangan', 50)->nullable();
            $table->string('pop', 12);
            $table->foreign('pop')->references('pop')->on('kantor_layanan')->onDelete('cascade');
            $table->string('qr_code', 100);
            $table->foreignId('stok_gudang_id')->constrained('stok_gudang')->onDelete('restrict');
            $table->timestamps();
        });
        schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('qr_code', 100);
            $table->foreignId('stok_gudang_id')->constrained('stok_gudang')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
        Schema::dropIfExists('order');
    }
};
