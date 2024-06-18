<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Refacciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_categoria',
        'id_marca',
        'id_linea',
        'id_clave_sat',
        'modelo',
        'cantidad',
        'sku',
        'informacion',
        'descripcion',
        'herramientas',
        'sintomas_fallas',
        'intercambios',
        'estatus',
        'fecha_cre',
        'fecha_mod',
    ];


    // public function categorias()
    // {

    // }
}
