<?php

namespace App\Services\BaseService\Interfaces;
interface Service
{
    public function index(array $data): mixed;

    public function show(int $id): mixed;

    public function store(array $data): mixed;

    public function update(int $id, array $data): ?int;

    public function destroy(int $id): ?bool;
}
