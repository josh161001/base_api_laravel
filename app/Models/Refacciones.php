<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Refacciones extends Model
{
    use HasFactory;

    protected $table = 'refacciones';

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
        "models",
        'position',
        'intercambios',
        'estatus',
    ];


    public function categorias()
    {
        return $this->belongsTo(categorias::class, 'id_categoria', 'id');
    }

    public function marcas()
    {
        return $this->belongsTo(marcas::class, 'id_marca', 'id');
    }

    public function lineas()
    {
        return $this->belongsTo(lineas::class, 'id_linea', 'id');
    }

    public function claves_sat()
    {
        return $this->belongsTo(claves_sat::class, 'id_clave_sat', 'id');
    }

    public function archivos()
    {
        return $this->hasMany(Archivos::class, 'id_refaccion');
    }
}
