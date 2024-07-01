<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'id_padre',
    ];

    // obtener Categorias hijas
    public function subcategorias()
    {
        return $this->hasMany(Categorias::class, 'id_padre', 'id')->with('subcategorias');
    }
    // obtener categoria padre
    public function categoria_padre()
    {
        return $this->belongsTo(Categorias::class, 'id_padre', 'id');
    }
    // obtener refacciones de la categoria
    public function refacciones()
    {
        return $this->hasMany(Refacciones::class, 'id_categoria', 'id');
    }
}
