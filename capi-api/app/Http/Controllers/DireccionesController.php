<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direcciones;
use App\Http\Controllers\BaseController;

class DireccionesController extends BaseController
{
    // get, post, put, delete
    public function index()
    {
        return $this->sendResponse(Direcciones::all(), 'Direcciones retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $direcciones = Direcciones::create($input);
        return $this->sendResponse($direcciones->toArray(), 'Direcciones created successfully.');
    }

    public function show($id)
    {
        $direcciones = Direcciones::find($id);
        if (is_null($direcciones)) {
            return $this->sendError('Direcciones not found.');
        }
        return $this->sendResponse($direcciones->toArray(), 'Direcciones retrieved successfully.');
    }

    public function update(Request $request, Direcciones $direcciones)
    {
        $input = $request->all();
        $direcciones->fill($input);
        $direcciones->save();
        return $this->sendResponse($direcciones->toArray(), 'Direcciones updated successfully.');
    }

    public function destroy($id)
    {
        $direcciones = Direcciones::find($id);
        if (is_null($direcciones)) {
            return $this->sendError('Direcciones not found.');
        }
        $direcciones->delete();
        return $this->sendResponse($direcciones->toArray(), 'Direcciones deleted successfully.');
    }
}
