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
            $table->id();
            $table->integer('jumlah');
            $table->string('input_by', 20);
            $table->string('foto');
            $table->string('kondisi', 50);
            $table->string('penyebab', 50);
            $table->string('pop', 12);
            $table->foreign('pop')->references('pop')->on('kantor_layanan')->onDelete('cascade');
            $table->string('qr_code', 255)->nullable();
            $table->foreignId('stok_gudang_id')->constrained('stok_gudang')->onDelete('restrict');
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
