<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaSecundaria extends Model
{
    use HasFactory;

    protected $table = 'categoria_secundarias';

    protected $fillable = [
        'nombre',
        'estado',
    ];

    public function propiedades()
    {
        return $this->hasMany(Propiedad::class);
    }
}
