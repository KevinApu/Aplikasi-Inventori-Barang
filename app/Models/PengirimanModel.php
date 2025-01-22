<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanModel extends Model
{
    use HasFactory;
    protected $table = 'riwayat_pengiriman'; // Nama tabel
    protected $fillable = [
        'id',
        'nama_barang',
        'seri',
        'jumlah',
        'satuan',
        'rasio',
        'catatan',
        'tujuan',
        'nama_pengaju',
        'status',
        'tanggal_terima',
        'tanggal_estimasi',
        'resi',
        'namakurir',
        'pengirim',
        'created_at',
        'updated_at'
    ];
}
