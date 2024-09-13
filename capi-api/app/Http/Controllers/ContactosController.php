<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ContactosRepository;
use App\Http\Controllers\BaseController;

class ContactosController extends BaseController
{
    private $contactosRepository;

    public function __construct(ContactosRepository $contactosRepository)
    {
        $this->contactosRepository = $contactosRepository;
    }

    public function index()
    {
        return $this->contactosRepository->all();
    }

    public function paginate(Request $request)
    {
        try {
            $search = $request->search ?? '';
            $page = $request->page ?? 1;
            $limit = $request->limit ?? 10;
            return $this->sendResponse($this->contactosRepository->allPaginated(
                $page,
                $limit,
                $search
            ), 'Contactos paginados correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error al paginar contactos', $e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
        ]);
        try {
            return $this->sendResponse($this->contactosRepository->create($request->all()), 'Contacto creado correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error al crear contacto', $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        return $this->contactosRepository->find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
        ]);
        try{
            return $this->sendResponse($this->contactosRepository->update($id, $request->all()), 'Contacto actualizado correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error al actualizar contacto', $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        return $this->contactosRepository->delete($id);
    }
}
