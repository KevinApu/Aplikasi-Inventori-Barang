<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = ['id','nama_barang', 'seri', 'foto', 'lokasi', 'username', 'stok', 'satuan' ,'pop', 'qr_code'];
    // Menonaktifkan primary key
    protected $primaryKey = null;

    // Menonaktifkan auto-increment
    public $incrementing = false;
}
