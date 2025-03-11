<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KLModel extends Model
{
    use HasFactory;
    protected $table = 'kantor_layanan';
    protected $fillable = ['id', 'pop', 'lokasi', 'alamat'];

    public function KLUser()
    {
        return $this->hasMany(KLUsers::class, 'kl_id', 'id');
    }

    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;
}
