<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefonos extends Model
{
    use HasFactory;
    protected $fillable = ['telefono', 'contactos_id', 'created_at', 'updated_at'];

    public function contacto()
    {
        return $this->belongsTo(Contactos::class);
    }
}
