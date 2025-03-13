<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarModel extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar';
    protected $fillable = ['id', 'jumlah', 'nama_customer', 'output_by', 'keterangan', 'lokasi', 'pop', 'qr_code', 'stok_gudang_id', 'status_order'];
    public function stokGudang()
    {
        return $this->belongsTo(StokGudangModel::class, 'stok_gudang_id', 'id');
    }
}
