<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarModel extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar';
    protected $fillable = ['id', 'kode_barang', 'kategori' ,'nama_barang', 'seri', 'jumlah', 'foto', 'nama_customer', 'output_by', 'keterangan', 'lokasi', 'pop', 'qr_code'];
    // Menonaktifkan primary key
    protected $primaryKey = null;

    // Menonaktifkan auto-increment
    public $incrementing = false;
}