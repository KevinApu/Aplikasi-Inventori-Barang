<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KLUsers extends Model
{
    use HasFactory;
    protected $table = 'kl_users';
    protected $fillable = ['id', 'username', 'password', 'role', 'pop_id'];

    public function User()
    {
        return $this->hasMany(Login::class, 'kl_user_id', 'id');
    }
    public function KLModel()
    {
        return $this->belongsTo(KLModel::class, 'pop_id', 'pop');
    }


    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;
}
