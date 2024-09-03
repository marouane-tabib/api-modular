<?php

namespace App\Repositories\BaseRepository;

use App\Models\Model;
use App\Repositories\BaseRepository\Interfaces\Repository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class BaseRepository implements Repository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get(array $select = ['*']): Collection
    {
        return $this->model->get($select);
    }

    public function all(array $select = ['*']): Collection
    {
        return $this->model->all($select);
    }

    public function paginate(int $paginate = 10): Paginator
    {
        return $this->model->paginate($paginate);
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function attach(string $relation, array $attributes = []): self
    {
        $this->model = $this->model->$relation()->attach($attributes);

        return $this;
    }

    public function update(int $id, array $data): ?int
    {
        return $this->findOrFail($id)->update($data);
    }

    public function sync(string $relation, array $attributes = []): self
    {
        $this->model = $this->model->$relation()->sync($attributes);

        return $this;
    }

    public function delete(int $id): ?bool
    {
        return $this->findOrFail($id)->delete();
    }

    public function with(...$with): self
    {
        $this->model = $this->model->with($with);

        return $this;
    }

    public function where(...$where): self
    {
        $this->model = $this->model->where($where);

        return $this;
    }

    public function select(...$select): self
    {
        $this->model = $this->model->select($select);

        return $this;
    }

    public function search(string $search): self
    {
        $this->model = $this->model->search($search);

        return $this;
    }

    public function order(string $column, string $direction = 'asc'): self
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    public function first(array $select = ['*']): ?Model
    {
        return $this->model->first($select);
    }
}
