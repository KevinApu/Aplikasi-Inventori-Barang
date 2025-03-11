<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KLUsers extends Model
{
    use HasFactory;
    protected $table = 'kl_users';
    protected $fillable = ['id', 'username', 'password', 'role', 'kl_id'];

    public function User()
    {
        return $this->hasMany(User::class, 'kl_user_id', 'id');
    }
    public function KLModel()
    {
        return $this->belongsTo(KLModel::class, 'kl_id', 'id');
    }


    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;
}
