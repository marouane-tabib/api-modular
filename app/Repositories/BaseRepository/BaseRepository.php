<?php

namespace App\Repositories\BaseRepository;

use App\Models\Model;
use App\Repositories\BaseRepository\Interfaces\Repository;

/**
 * Class BaseRepository
 *
 * This class implements the Repository interface and provides
 * basic operations for Eloquent models.
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
     * @param  array    $select Columns to select.
     * @return iterable
     */
    public function get(array $select = ['*']): iterable
    {
        return $this->model->get($select);
    }

    /**
     * Get all records.
     *
     * @param  array    $select Columns to select
     * @return iterable
     */
    public function all(array $select = ['*']): iterable
    {
        return $this->model->all($select);
    }

    /**
     * Paginate the results.
     *
     * @param  int      $paginate Number of items per page.
     * @return iterable
     */
    public function paginate(int $paginate = 10): iterable
    {
        return $this->model->paginate($paginate);
    }

    /**
     * Find a record by its ID.
     *
     * @param  int|string $id
     * @return ?object
     */
    public function find(int|string $id): ?object
    {
        return $this->model->find($id);
    }

    /**
     * Find a record by its ID or throw an exception if not found.
     *
     * @param  int|string                                           $id
     * @return object
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int|string $id): object
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record.
     *
     * @param  array  $data
     * @return object
     */
    public function create(array $data): object
    {
        return $this->model->create($data);
    }

    /**
     * Attach related models.
     *
     * @param  string $relation
     * @param  array  $attributes
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
     * @param  int|string $id
     * @param  array      $data
     * @return bool
     */
    public function update(int|string $id, array $data): bool
    {
        return (bool) $this->findOrFail($id)->update($data);
    }

    /**
     * Sync related models.
     *
     * @param  string $relation
     * @param  array  $attributes
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
     * @param  int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return (bool) $this->findOrFail($id)->delete();
    }

    /**
     * Add a "with" clause to the query.
     *
     * @param  mixed ...$with
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
     * @param  mixed ...$where
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
     * @param  mixed ...$select
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
     * @param  string $search
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
     * @param  string $column
     * @param  string $direction
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
     * @param  array   $select Columns to select
     * @return ?object
     */
    public function first(array $select = ['*']): ?object
    {
        return $this->model->first($select);
    }
}
