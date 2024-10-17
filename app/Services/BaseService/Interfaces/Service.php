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
     * Retrieve and paginate a list of resources.
     *
     * @param  array $data An array of parameters for filtering, sorting, and pagination
     * @return mixed The paginated result set
     */
    public function index(array $data): mixed;

    /**
     * Retrieve a specific resource by its ID.
     *
     * @param  int   $id The ID of the resource to retrieve
     * @return mixed The retrieved resource
     */
    public function show(int $id): mixed;

    /**
     * Create a new resource.
     *
     * @param  array $data The data for creating the new resource
     * @return mixed The newly created resource
     */
    public function store(array $data): mixed;

    /**
     * Update an existing resource.
     *
     * @param  int      $id   The ID of the resource to update
     * @param  array    $data The data for updating the resource
     * @return int|null The number of affected rows or null if the update failed
     */
    public function update(int $id, array $data): ?int;

    /**
     * Delete a specific resource.
     *
     * @param  int       $id The ID of the resource to delete
     * @return bool|null True if the deletion was successful, false or null otherwise
     */
    public function destroy(int $id): ?bool;
}
