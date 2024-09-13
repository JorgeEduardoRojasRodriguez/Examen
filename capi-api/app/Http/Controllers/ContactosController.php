<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contactos;

class ContactosController extends Controller
{
    // generar get, post, put, delete
    public function index()
    {
        return Contactos::all();
    }

    public function paginate(Request $request)
    {
        $limit = $request->limit;
        $offset = $request->offset;
        return Contactos::limit($limit)->offset($offset)->get();
    }

    public function store(Request $request)
    {
        // agregar validacion de datos
        $request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
        ]);

        $contacto = new Contactos();
        $contacto->nombre = $request->nombre;
        $contacto->apellido_paterno = $request->apellido_paterno;
        $contacto->apellido_materno = $request->apellido_materno;
        $contacto->save();
        return $contacto;
    }

    public function show($id)
    {
        return Contactos::find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
        ]);

        $contacto = Contactos::find($id);
        $contacto->nombre = $request->nombre;
        $contacto->apellido_paterno = $request->apellido_paterno;
        $contacto->apellido_materno = $request->apellido_materno;
        $contacto->save();
        return $contacto;
    }

    public function destroy($id)
    {
        $contacto = Contactos::find($id);
        $contacto->delete();
        return $contacto;
    }

}
