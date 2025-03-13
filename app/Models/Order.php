<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = ['id', 'qr_code', 'stok_gudang_id', 'users_id'];
    public function stokGudang()
    {
        return $this->belongsTo(StokGudangModel::class, 'stok_gudang_id', 'id');
    }    
    public function userId()
    {
        return $this->belongsTo(Login::class, 'users_id', 'id');
    }
}
