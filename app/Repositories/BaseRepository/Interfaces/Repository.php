<?php

namespace App\Repositories\BaseRepository\Interfaces;

interface Repository
{
    public function all(array $select = ['*']): mixed;

    public function get(array $select = ['*']): mixed;

    public function paginate(int $paginate = 10): mixed;

    public function find(int $id): mixed;

    public function findOrFail(int $id): mixed;

    public function create(array $data): mixed;

    public function attach(string $relation, array $attributes = []): self;

    public function update(int $id, array $data): ?int;

    public function sync(string $relation, array $attributes = []): self;

    public function delete(int $id): ?bool;

    public function with(...$with): self;

    public function where(...$where): self;

    public function select(...$select): self;

    public function search(string $search): self;

    public function order(string $column, string $direction = 'asc'): self;

    public function first(array $select = ['*']): mixed;
}
