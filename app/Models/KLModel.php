<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KLModel extends Model
{
    use HasFactory;
    protected $table = 'kantor_layanan';
    protected $fillable = ['pop', 'lokasi', 'alamat'];

    public function KLUser()
    {
        return $this->hasMany(KLUsers::class, 'pop_id', 'pop');
    }

    public function RequestBarang()
    {
        return $this->hasMany(RequestBarangModel::class, 'pop', 'pop');
    }

    public function RiwayatPengiriman()
    {
        return $this->hasMany(KLUsers::class, 'tujuan', 'pop');
    }

    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;
}
