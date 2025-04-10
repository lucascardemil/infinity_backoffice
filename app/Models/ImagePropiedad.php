<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagePropiedad extends Model
{
    use HasFactory;

    protected $table = 'imagenes_propiedades';

    protected $fillable = [
        'propiedad_id',
        'principal',
        'posicion',
        'ruta_imagen',
        'estado',
    ];

    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class, 'propiedad_id');
    }
}
