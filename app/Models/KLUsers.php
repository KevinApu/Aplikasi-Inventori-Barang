<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KLUsers extends Model
{
    use HasFactory;
    protected $table = 'kl_users';
    protected $fillable = ['id', 'username', 'password', 'role', 'pop'];

    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;
}
