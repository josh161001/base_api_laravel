<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lineas extends Model
{
    use HasFactory;

    protected $table = 'lineas';

    protected $fillable = [
        'nombre',
    ];

    // obtener refacciones de la linea
    public function refacciones()
    {
        return $this->hasMany(Refacciones::class, 'id_linea', 'id');
    }
}
