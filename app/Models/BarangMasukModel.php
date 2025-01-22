<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

    class BarangMasukModel extends Authenticatable
    {
        use HasFactory;
        protected $table = 'barang_masuk'; // Nama tabel
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
