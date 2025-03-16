<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBarangModel extends Model
{
    use HasFactory;
    protected $table = 'request_barang';
    protected $fillable = [
        'id',
        'nama_barang',
        'seri',
        'jumlah',
        'satuan',
        'rasio',
        'catatan',
        'pop',
        'nama_pengaju',
        'status',
        'ket_status',
        'tanggal_terima',
        'tanggal_estimasi',
        'resi',
        'namakurir',
        'pengirim',
        'created_at',
        'updated_at'
    ];
    public function KLModel()
    {
        return $this->belongsTo(KLModel::class, 'pop', 'pop');
    }
}
