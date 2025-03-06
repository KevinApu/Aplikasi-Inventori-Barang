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
        'stok_awal',
        'in',
        'out',
        'pop',
        'stok_gudang_id',
        'created_at',
        'updated_at'
    ];

    public function stokGudang()
    {
        return $this->belongsTo(StokGudangModel::class, 'stok_gudang_id', 'id');
    }
}
