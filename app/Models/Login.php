<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    use HasFactory;
    protected $table = "users";
    // Kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'username',
        'password',
        'role',
        'request_access',
        'foto',
        'last_login',
        'pop_id',
    ];

    public function KLModel()
    {
        return $this->belongsTo(KLModel::class, 'pop_id', 'pop');
    }
    // Kolom yang disembunyikan saat serialisasi (misal: API response)
}
