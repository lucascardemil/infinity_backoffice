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
        'valor_uf',
        'cantidad',
        'tipo_valor',
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

    public function tipo_propiedad()
    {
        return $this->belongsTo(TipoPropiedad::class, 'tipo_propiedad_id');
    }

    public function formato_negocio()
    {
        return $this->belongsTo(FormatoNegocio::class, 'formato_negocio_id');
    }

    public function categoria_secundaria()
    {
        return $this->belongsTo(CategoriaSecundaria::class, 'categoria_secundaria_id');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
