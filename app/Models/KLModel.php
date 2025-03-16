<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KLModel extends Model
{
    use HasFactory;
    protected $table = 'kantor_layanan';
    protected $fillable = ['pop', 'lokasi', 'alamat'];


    public function User()
    {
        return $this->hasMany(Login::class, 'pop_id', 'id');
    }

    public function RequestBarang()
    {
        return $this->hasMany(RequestBarangModel::class, 'pop', 'pop');
    }
    public $timestamps = false;
}
