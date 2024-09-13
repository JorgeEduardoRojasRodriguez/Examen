<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Telefonos;
use App\Http\Controllers\BaseController;

class TelefonosController extends BaseController
{
    // get, post, put, delete
    public function index()
    {
        return $this->sendResponse(Telefonos::all(), 'Telefonos retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $telefonos = Telefonos::create($input);
        return $this->sendResponse($telefonos->toArray(), 'Telefonos created successfully.');
    }


    public function show($id)
    {
        $telefonos = Telefonos::find($id);
        if (is_null($telefonos)) {
            return $this->sendError('Telefonos not found.');
        }
        return $this->sendResponse($telefonos->toArray(), 'Telefonos retrieved successfully.');
    }


    public function update(Request $request, Telefonos $telefonos)
    {
        $input = $request->all();
        $telefonos->fill($input);
        $telefonos->save();
        return $this->sendResponse($telefonos->toArray(), 'Telefonos updated successfully.');
    }


    public function destroy($id)
    {
        $telefonos = Telefonos::find($id);
        if (is_null($telefonos)) {
            return $this->sendError('Telefonos not found.');
        }
        $telefonos->delete();
        return $this->sendResponse($telefonos->toArray(), 'Telefonos deleted successfully.');
    }
}
