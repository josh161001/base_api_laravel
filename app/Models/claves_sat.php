<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class claves_sat extends Model
{
    use HasFactory;

    protected $table = 'claves_sat';

    protected $fillable = [
        'clave',
    ];

    // obtener refacciones de la clave sat
    public function refacciones()
    {
        return $this->hasMany(Refacciones::class, 'id_clave_sat', 'id');
    }
}
