<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'id_usuario',
        'nombre',
        'RFC',
        'informacion_adicional',
        'contacto',
        'fecha_reg',
        'observaciones',
        'estatus',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    protected $casts = [
        'informacion_adicional' => 'json',
        'contacto' => 'json',
    ];
}
