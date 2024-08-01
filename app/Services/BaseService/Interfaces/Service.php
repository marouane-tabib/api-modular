<?php

namespace App\Services\BaseService\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface Service
{
    public function index(array $data): Paginator|Model|null|Collection;

    public function show(int $id): ?Model;

    public function store(array $data): Model;

    public function update(int $id, array $data): ?int;

    public function destroy(int $id): ?bool;
}
