<?php

namespace App\Repositories\BaseRepository\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface Repository
{
    public function all(array $select = ['*']): Collection;

    public function get(array $select = ['*']): Collection;

    public function paginate(int $paginate = 10): Paginator;

    public function find(int $id): ?Model;

    public function findOrFail(int $id): ?Model;

    public function create(array $data): Model;

    public function update(int $id, array $data): ?int;

    public function delete(int $id): ?bool;

    public function with(...$with): self;

    public function where(...$where): self;

    public function select(...$select): self;

    public function search(string $search): self;

    public function order(string $column, string $direction = 'asc'): self;
    
    public function first(array $select = ['*']): ?Model;
}
