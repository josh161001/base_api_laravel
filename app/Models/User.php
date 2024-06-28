<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_completo',
        'correo',
        'contrasena',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'correo_verified_at' => 'datetime',
            'contrasena' => 'hashed',
        ];
    }


    // relaciones

    // obtener subUsuarios hijas de usuario
    public function subUsuarios()
    {
        return $this->hasMany(User::class, 'id_padre', 'id')->with('subUsuarios');
    }
    // obtener usuario padre
    public function usuario_padre()
    {
        return $this->belongsTo(User::class, 'id_padre', 'id');
    }

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'id_rol', 'id');
    }

    public function clientes()
    {
        return $this->hasMany(Clientes::class, 'id_usuario', 'id');
    }
}
