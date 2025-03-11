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
        'request_access',
        'foto',
        'last_login', 
        'kl_user_id',
    ];

    public function KLUser()
    {
        return $this->belongsTo(KLUsers::class, 'kl_user_id', 'id');
    }

    // Kolom yang disembunyikan saat serialisasi (misal: API response)
    protected $hidden = [
        'password',  // Sembunyikan password saat mengirim data ke client
    ];
}
