<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'notas',
        'fecha_nacimiento',
        'pagina_web',
        'empresa',
        'created_at',
        'updated_at'
    ];

    public function telefonos()
    {
        return $this->hasMany(Telefonos::class);
    }

    public function emails()
    {
        return $this->hasMany(Emails::class);
    }

    public function direcciones()
    {
        return $this->hasMany(Direcciones::class);
    }
}
