<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatoNegocio extends Model
{
    use HasFactory;

    protected $table = 'formato_negocios';

    protected $fillable = [
        'nombre',
        'estado',
    ];

    public function propiedades()
    {
        return $this->hasMany(Propiedad::class);
    }
}
