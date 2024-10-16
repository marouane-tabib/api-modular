<?php

namespace App\Repositories\BaseRepository\Interfaces;

/**
 * Interface Repository
 *
 * Defines the contract for repository operations.
 */
interface Repository
{
    /**
     * Retrieve all records.
     *
     * @param array $select Columns to select
     * @return mixed
     */
    public function all(array $select = ['*']): mixed;

    /**
     * Get records based on the current query.
     *
     * @param array $select Columns to select
     * @return mixed
     */
    public function get(array $select = ['*']): mixed;

    /**
     * Paginate the results.
     *
     * @param int $paginate Number of items per page
     * @return mixed
     */
    public function paginate(int $paginate = 10): mixed;

    /**
     * Find a record by its ID.
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed;

    /**
     * Find a record by its ID or throw an exception if not found.
     *
     * @param int $id
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): mixed;

    /**
     * Create a new record.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Attach related models.
     *
     * @param string $relation
     * @param array $attributes
     * @return self
     */
    public function attach(string $relation, array $attributes = []): self;

    /**
     * Update an existing record.
     *
     * @param int $id
     * @param array $data
     * @return int|null
     */
    public function update(int $id, array $data): ?int;

    /**
     * Sync related models.
     *
     * @param string $relation
     * @param array $attributes
     * @return self
     */
    public function sync(string $relation, array $attributes = []): self;

    /**
     * Delete a record.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;

    /**
     * Add a "with" clause to the query.
     *
     * @param mixed ...$with
     * @return self
     */
    public function with(...$with): self;

    /**
     * Add a "where" clause to the query.
     *
     * @param mixed ...$where
     * @return self
     */
    public function where(...$where): self;

    /**
     * Set the columns to be selected.
     *
     * @param mixed ...$select
     * @return self
     */
    public function select(...$select): self;

    /**
     * Add a search condition to the query.
     *
     * @param string $search
     * @return self
     */
    public function search(string $search): self;

    /**
     * Set the order for the query results.
     *
     * @param string $column
     * @param string $direction
     * @return self
     */
    public function order(string $column, string $direction = 'asc'): self;

    /**
     * Get the first record matching the query.
     *
     * @param array $select Columns to select
     * @return mixed
     */
    public function first(array $select = ['*']): mixed;
}
