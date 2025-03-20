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
        'jumlah',  
        'input_by',
        'foto',
        'kondisi',
        'penyebab',
        'pop',
        'qr_code',
        'stok_gudang_id',
    ];

    public function stokGudang()
    {
        return $this->belongsTo(StokGudangModel::class, 'stok_gudang_id', 'id');
    }
}
