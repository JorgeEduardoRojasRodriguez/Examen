<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'contactos_id', 'created_at', 'updated_at'];

    public function contacto()
    {
        return $this->belongsTo(Contactos::class);
    }
}
