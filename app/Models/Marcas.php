<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
    use HasFactory;

    protected $table = 'Marcas';

    protected $fillable = [
        'nombre',
    ];

    // obtener refacciones de la marca
    public function refacciones()
    {
        return $this->hasMany(Refacciones::class, 'id_marca', 'id');
    }
}
