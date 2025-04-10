<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = 'propiedades';

    protected $fillable = [
        'user_id',
        'titulo',
        'tipo_propiedad_id',
        'formato_negocio_id',
        'valor_pesos',
        'ubicacion_id',
        'm2_superficie',
        'm2_construido',
        'pisos',
        'dormitorios',
        'banos',
        'categoria_secundaria_id',
        'atributos_adicionales',
        'descripcion',
        'direccion',
        'estado'
    ];

    public function imagenes()
    {
        return $this->hasMany(ImagePropiedad::class);
    }
}
