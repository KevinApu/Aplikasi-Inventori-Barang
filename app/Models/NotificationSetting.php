<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;
    protected $table = 'notifications_settings';
    protected $fillable = ['id','roll', 'pack', 'unit', 'pcs', 'pop'];
    // Menonaktifkan timestamp jika tidak digunakan
    public $timestamps = false;
}
