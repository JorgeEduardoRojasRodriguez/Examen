<?php

namespace App\Interface;

use App\Models\Contactos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ContactosRepositoryInterface
{
    public function all(): Collection;
    public function allPaginated(int $perPage = 10): LengthAwarePaginator;
    public function find(int $id): ?Contactos;
    public function create(array $data): Contactos;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
