<?php

namespace App\Models\BarangMasuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'kategori'; // Nama tabel
    protected $fillable = ['kategori', 'pop'];
}
