<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributoAdicional extends Model
{
    use HasFactory;

    protected $table = 'atributo_adicionales';

    protected $fillable = [
        'nombre',
        'estado',
        'ruta_imagen',
    ];
}
