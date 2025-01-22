<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokGudangModel extends Model
{
    use HasFactory;
    protected $table = 'stok_gudang'; // Nama tabel
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
        'lokasi',
        'foto',
        'input_by',
        'keterangan',
        'pop',
        'created_at',
        'updated_at',
    ];
}
