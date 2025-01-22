<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KLModel extends Model
{
    use HasFactory;
    protected $table = 'kantor_layanan';
    protected $fillable = ['id', 'pop', 'kepalakantor', 'lokasi', 'alamat', 'password_superadmin'];

    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;
}
