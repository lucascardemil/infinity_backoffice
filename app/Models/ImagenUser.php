<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenUser extends Model
{
    use HasFactory;

    protected $table = 'imagen_users';

    protected $fillable = [
        'user_id',
        'ruta_imagen',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
