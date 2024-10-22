<?php

namespace App\Services\BaseService\Interfaces;

/**
 * Interface Service
 *
 * Defines the contract for service operations.
 */
interface Service
{
    /**
     * Retrieve and paginate a list of records.
     *
     * @param  array    $data An array of parameters for filtering, sorting, and pagination
     * @return iterable The paginated result set
     */
    public function index(array $data): iterable;

    /**
     * Retrieve a specific record by its ID or UUID.
     *
     * @param  int|string $id The ID or UUID of the record to retrieve
     * @return object     The retrieved record
     * @throws \Exception If the record is not found
     */
    public function show(int|string $id): object;

    /**
     * Create a new record.
     *
     * @param  array  $data The data for creating the new record
     * @return object The newly created record
     */
    public function store(array $data): object;

    /**
     * Update an existing record.
     *
     * @param  int|string $id   The ID or UUID of the record to update
     * @param  array      $data The data for updating the record
     * @return bool       True if the update was successful
     * @throws \Exception If the record is not found
     */
    public function update(int|string $id, array $data): bool;

    /**
     * Delete a specific record.
     *
     * @param  int|string $id The ID or UUID of the record to delete
     * @return bool       True if the deletion was successful
     * @throws \Exception If the record is not found
     */
    public function destroy(int|string $id): bool;
}
