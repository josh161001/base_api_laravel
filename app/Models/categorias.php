<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorias extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'id_padre',
    ];

    // obtener categorias hijas
    public function subcategorias()
    {
        return $this->hasMany(categorias::class, 'id_padre', 'id');
    }

    // obtener categoria padre
    public function categoria_padre()
    {
        return $this->belongsTo(categorias::class, 'id_padre', 'id');
    }

    // obtener refacciones de la categoria
    public function refacciones()
    {
        return $this->hasMany(Refacciones::class, 'id_categoria', 'id');
    }
}
