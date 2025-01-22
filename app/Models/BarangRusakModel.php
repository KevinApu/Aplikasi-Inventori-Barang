<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangRusakModel extends Model
{
    use HasFactory;
    protected $table = 'barang_rusak'; // Nama tabel
    protected $fillable = [
        'id',
        'kode_barang',
        'kategori',
        'nama_barang',
        'seri',
        'jumlah',  
        'input_by',
        'foto',
        'kondisi',
        'penyebab',
        'pop',
        'qr_code',
        'status'
    ];

    // Menonaktifkan primary key
    protected $primaryKey = null;

    // Menonaktifkan auto-increment
    public $incrementing = false;
}
