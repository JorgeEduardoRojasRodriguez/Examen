<?php

namespace App\Repositories;

use App\Models\Contactos;
use App\Models\Emails;
use App\Models\Telefonos;
use App\Models\Direcciones;
use Illuminate\Database\Eloquent\Collection;
use App\Interface\ContactosRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactosRepository implements ContactosRepositoryInterface
{
    public function all(): Collection
    {
        return Contactos::orderBy('created_at', 'asc')
            ->get();
    }

    public function allPaginated(
        int $page = 1,
        int $limit = 10,
        string $query = ''
    ): LengthAwarePaginator {
        return Contactos::with(['emails', 'telefonos', 'direcciones'])
            ->orderBy('created_at', 'desc')
            ->where('nombre', 'like', "%$query%")
            ->orWhere('apellido_paterno', 'like', "%$query%")
            ->orWhere('apellido_materno', 'like', "%$query%")
            ->orWhere('notas', 'like', "%$query%")
            ->orWhere('fecha_nacimiento', 'like', "%$query%")
            ->orWhereHas('emails', function ($emailQuery) use ($query) {
                $emailQuery->where('email', 'like', "%$query%");
            })
            ->orWhereHas('telefonos', function ($telefonoQuery) use ($query) {
                $telefonoQuery->where('telefono', 'like', "%$query%");
            })
            ->orWhereHas('direcciones', function ($direccionQuery) use ($query) {
                $direccionQuery->where('calle', 'like', "%$query%")
                    ->orWhere('numero', 'like', "%$query%")
                    ->orWhere('colonia', 'like', "%$query%")
                    ->orWhere('codigo_postal', 'like', "%$query%")
                    ->orWhere('ciudad', 'like', "%$query%")
                    ->orWhere('estado', 'like', "%$query%")
                    ->orWhere('pais', 'like', "%$query%");
            })
            ->paginate($limit, ['*'], 'page', $page);
    }

    public function find(int $id): ?Contactos
    {
        return Contactos::find($id);
    }

    public function create(array $data): Contactos
    {
        $dataContacto = [
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'notas' => $data['notas'] ?? null,
            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
            'pagina_web' => $data['pagina_web'] ?? null,
        ];

        $Contactos = Contactos::create($dataContacto);

        if (isset($data['emails'])) {
            foreach ($data['emails'] as $email) {
                Emails::create([
                    'contactos_id' => $Contactos->id,
                    'email' => $email['email'],
                ]);
            }
        }

        if (isset($data['telefonos'])) {
            foreach ($data['telefonos'] as $telefono) {
                Telefonos::create([
                    'contactos_id' => $Contactos->id,
                    'telefono' => $telefono['telefono'] ?? null,
                ]);
            }
        }

        if (isset($data['direcciones'])) {
            foreach ($data['direcciones'] as $direccion) {
                Direcciones::create([
                    'contactos_id' => $Contactos->id,
                    'calle' => $direccion['calle'] ?? null,
                    'numero' => $direccion['numero'] ?? null,
                    'colonia' => $direccion['colonia'] ?? null,
                    'codigo_postal' => $direccion['codigo_postal'] ?? null,
                    'ciudad' => $direccion['ciudad'] ?? null,
                    'estado' => $direccion['estado'] ?? null,
                    'pais' => $direccion['pais'] ?? null,
                ]);
            }
        }

        return $Contactos;
    }

    public function update(int $id, array $data): bool
    {
        $dataContacto = [
            'nombre' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'notas' => $data['notas'] ?? null,
            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
            'pagina_web' => $data['pagina_web'] ?? null,
        ];
        $Contactos = $this->find($id);
        if (!$Contactos) {
            return false;
        }

        $Contacto = $Contactos->update($dataContacto);

        if (isset($data['emails'])) {
            foreach ($data['emails'] as $email) {
                // si viene con id, actualizamos
                if (isset($email['id'])) {
                    $Emails = Emails::find($email['id']);
                    if ($Emails) {
                        $Emails->update([
                            'email' => $email['email'],
                        ]);
                    }
                } else {
                    Emails::create([
                        'contactos_id' => $Contactos->id,
                        'email' => $email['email'],
                    ]);
                }
            }
        }


        if (isset($data['telefonos'])) {
            foreach ($data['telefonos'] as $telefono) {
                // si viene con id, actualizamos
                if (isset($telefono['id'])) {
                    $Telefonos = Telefonos::find($telefono['id']);
                    if ($Telefonos) {
                        $Telefonos->update([
                            'telefono' => $telefono['telefono'],
                        ]);
                    }
                } else {
                    Telefonos::create([
                        'contactos_id' => $Contactos->id,
                        'telefono' => $telefono['telefono'],
                    ]);
                }
            }
        }


        if (isset($data['direcciones'])) {
            foreach ($data['direcciones'] as $direccion) {
                // si viene con id, actualizamos
                if (isset($direccion['id'])) {
                    $Direcciones = Direcciones::find($direccion['id']);
                    if ($Direcciones) {
                        $Direcciones->update([
                            'calle' => $direccion['calle'],
                            'numero' => $direccion['numero'],
                            'colonia' => $direccion['colonia'],
                            'codigo_postal' => $direccion['codigo_postal'],
                            'ciudad' => $direccion['ciudad'],
                            'estado' => $direccion['estado'],
                            'pais' => $direccion['pais'],
                        ]);
                    }
                } else {
                    Direcciones::create([
                        'contactos_id' => $Contactos->id,
                        'calle' => $direccion['calle'],
                        'numero' => $direccion['numero'],
                        'colonia' => $direccion['colonia'],
                        'codigo_postal' => $direccion['codigo_postal'],
                        'ciudad' => $direccion['ciudad'],
                        'estado' => $direccion['estado'],
                        'pais' => $direccion['pais'],
                    ]);
                }
            }
        }


        return $Contacto;
    }

    public function delete(int $id): bool
    {
        $Contactos = $this->find($id);
        if (!$Contactos) {
            return false;
        }
        return $Contactos->delete();
    }
}
