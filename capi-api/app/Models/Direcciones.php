<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direcciones extends Model
{
    use HasFactory;
    protected $fillable = ['calle', 'numero', 'colonia', 'ciudad', 'codigo_postal', 'estado', 'pais', 'contacto_id', 'created_at', 'updated_at'];

    public function contacto()
    {
        return $this->belongsTo(Contactos::class);
    }
}
