<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapModel extends Model
{
    use HasFactory;
    protected $table = 'rekap'; // Nama tabel
    protected $fillable = [
        'id',
        'kode_barang',
        'kategori',
        'nama_barang',
        'seri',
        'jumlah',
        'satuan',
        'rasio',
        'hasil',
        'detail_jumlah',
        'stok_awal',
        'in',
        'out',
        'pop',
        'created_at',
        'updated_at'
    ];
}
