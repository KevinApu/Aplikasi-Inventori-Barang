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
            $table->integer('jumlah')->nullable();
            $table->string('lokasi', 200)->nullable();
            $table->string('nama_customer', 20)->nullable();
            $table->string('output_by', 20);
            $table->boolean('status_order')->default(0);
            $table->string('keterangan', 50)->nullable();
            $table->string('pop', 12);
            $table->foreign('pop')->references('pop')->on('kantor_layanan')->onDelete('cascade');
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
