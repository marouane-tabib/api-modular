<?php

namespace App\Repositories\BaseRepository;

use App\Models\Model;
use App\Repositories\BaseRepository\Interfaces\Repository;

/**
 * Class BaseRepository
 *
 * This class implements the Repository interface and provides
 *
 * @package App\Repositories\BaseRepository
 */
class BaseRepository implements Repository
{
    /**
     * @var Model The Eloquent model instance.
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model The Eloquent model instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     *
     * @param array $select Columns to select.
     * @return mixed
     */
    public function get(array $select = ['*']): mixed
    {
        return $this->model->get($select);
    }

    /**
     * Get all records.
     *
     * @param array $select Columns to select.
     * @return mixed
     */
    public function all(array $select = ['*']): mixed
    {
        return $this->model->all($select);
    }

    /**
     * Paginate the results.
     *
     * @param int $paginate Number of items per page.
     * @return mixed
     */
    public function paginate(int $paginate = 10): mixed
    {
        return $this->model->paginate($paginate);
    }

    /**
     * Find a record by its ID.
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return $this->model->find($id);
    }

    /**
     * Find a record by its ID or throw an exception if not found.
     *
     * @param int $id
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Attach related models.
     *
     * @param string $relation
     * @param array $attributes
     * @return self
     */
    public function attach(string $relation, array $attributes = []): self
    {
        $this->model = $this->model->$relation()->attach($attributes);

        return $this;
    }

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array $data
     * @return int|null
     */
    public function update(int $id, array $data): ?int
    {
        return $this->findOrFail($id)->update($data);
    }

    /**
     * Sync related models.
     *
     * @param string $relation
     * @param array $attributes
     * @return self
     */
    public function sync(string $relation, array $attributes = []): self
    {
        $this->model = $this->model->$relation()->sync($attributes);

        return $this;
    }

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        return $this->findOrFail($id)->delete();
    }

    /**
     * Add a "with" clause to the query.
     *
     * @param mixed ...$with
     * @return self
     */
    public function with(...$with): self
    {
        $this->model = $this->model->with($with);

        return $this;
    }

    /**
     * Add a "where" clause to the query.
     *
     * @param mixed ...$where
     * @return self
     */
    public function where(...$where): self
    {
        $this->model = $this->model->where($where);

        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @param mixed ...$select
     * @return self
     */
    public function select(...$select): self
    {
        $this->model = $this->model->select($select);

        return $this;
    }

    /**
     * Add a search condition to the query.
     *
     * @param string $search
     * @return self
     */
    public function search(string $search): self
    {
        $this->model = $this->model->search($search);

        return $this;
    }

    /**
     * Set the order for the query results.
     *
     * @param string $column
     * @param string $direction
     * @return self
     */
    public function order(string $column, string $direction = 'asc'): self
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    /**
     * Get the first record matching the query.
     *
     * @param array $select Columns to select
     * @return mixed
     */
    public function first(array $select = ['*']): mixed
    {
        return $this->model->first($select);
    }
}
