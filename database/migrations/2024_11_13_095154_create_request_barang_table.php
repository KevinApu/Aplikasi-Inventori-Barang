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
        Schema::create('request_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang', 50);
            $table->string('seri', 70);
            $table->integer('jumlah');
            $table->enum('satuan', ['Pcs', 'Roll', 'Pack', 'Unit'])->default(NULL);
            $table->integer('rasio')->nullable();
            $table->string('catatan', 50)->nullable();
            $table->string('pop', 12);
            $table->foreign('pop')->references('pop')->on('kantor_layanan')->onDelete('cascade');
            $table->string('nama_pengaju', 20);
            $table->enum('status', ['Menunggu Pengiriman', 'Sedang Dikirim', 'Dibatalkan', 'Pending', 'Setujui', 'Tolak'])->default('Pending');
            $table->string('ket_status', 50)->nullable();
            $table->datetime('tanggal_terima')->nullable();
            $table->datetime('tanggal_estimasi')->nullable();
            $table->string('resi', 30)->nullable();
            $table->string('namakurir', 20)->nullable();
            $table->string('pengirim', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Request_barang');
    }
};
