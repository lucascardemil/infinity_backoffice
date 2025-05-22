<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'user_id',
        'nombre',
        'email',
        'telefono',
        'mensaje',
        'propiedad',
        'estado'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
