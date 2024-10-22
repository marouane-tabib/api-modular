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
     * @param  array    $select Columns to select
     * @return iterable
     */
    public function all(array $select = ['*']): iterable;

    /**
     * Get records based on the current query.
     *
     * @param  array    $select Columns to select
     * @return iterable
     */
    public function get(array $select = ['*']): iterable;

    /**
     * Paginate the results.
     *
     * @param  int      $perPage Number of items per page
     * @return iterable
     */
    public function paginate(int $perPage = 10): iterable;

    /**
     * Find a record by its ID.
     *
     * @param  int|string $id
     * @return ?object
     */
    public function find(int|string $id): ?object;

    /**
     * Find a record by its ID or throw an exception if not found.
     *
     * @param  int|string $id
     * @return object
     * @throws \Exception If the record is not found
     */
    public function findOrFail(int|string $id): object;

    /**
     * Create a new record.
     *
     * @param  array  $data
     * @return object
     */
    public function create(array $data): object;

    /**
     * Attach related models.
     *
     * @param  string $relation
     * @param  array  $attributes
     * @return self
     */
    public function attach(string $relation, array $attributes = []): self;

    /**
     * Update an existing record.
     *
     * @param  int|string $id
     * @param  array      $data
     * @return bool
     * @throws \Exception If the record is not found
     */
    public function update(int|string $id, array $data): bool;

    /**
     * Sync related models.
     *
     * @param  string $relation
     * @param  array  $attributes
     * @return self
     */
    public function sync(string $relation, array $attributes = []): self;

    /**
     * Delete a record.
     *
     * @param  int|string $id
     * @return bool
     * @throws \Exception If the record is not found
     */
    public function delete(int|string $id): bool;

    /**
     * Add a "with" clause to the query.
     *
     * @param  mixed ...$with
     * @return self
     */
    public function with(...$with): self;

    /**
     * Add a "where" clause to the query.
     *
     * @param  mixed ...$where
     * @return self
     */
    public function where(...$where): self;

    /**
     * Set the columns to be selected.
     *
     * @param  mixed ...$select
     * @return self
     */
    public function select(...$select): self;

    /**
     * Add a search condition to the query.
     *
     * @param  string $search
     * @return self
     */
    public function search(string $search): self;

    /**
     * Set the order for the query results.
     *
     * @param  string $column
     * @param  string $direction
     * @return self
     */
    public function order(string $column, string $direction = 'asc'): self;

    /**
     * Get the first record matching the query.
     *
     * @param  array   $select Columns to select
     * @return ?object
     */
    public function first(array $select = ['*']): ?object;
}
