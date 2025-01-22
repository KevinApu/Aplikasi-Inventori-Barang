<?php

namespace App\Models\BarangMasuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nama_barang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'nama_barang'; // Nama tabel
    protected $fillable = ['nama_barang', 'pop'];
}
