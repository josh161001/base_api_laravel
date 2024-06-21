<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivos extends Model
{
    use HasFactory;

    protected $table = 'archivos';

    protected $fillable = [
        'id_refaccion',
        'url_multimedia',
    ];


    public function refaccion()
    {
        return $this->belongsTo(Refacciones::class, 'id_refaccion');
    }
}
