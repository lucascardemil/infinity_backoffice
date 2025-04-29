<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';

    protected $fillable = [
        'region',
        'ciudad',
        'estado'
    ];

    public function propiedades()
    {
        return $this->hasMany(Propiedad::class);
    }
}
