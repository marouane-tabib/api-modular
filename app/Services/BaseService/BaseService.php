<?php

namespace App\Services\BaseService;

use App\Repositories\BaseRepository\Interfaces\Repository;
use App\Services\BaseService\Interfaces\Service;

/**
 * Class BaseService
 *
 * This class implements the Service interface and provides
 * basic CRUD operations using a repository.
 *
 * @package App\Services\BaseService
 */
class BaseService implements Service
{
    /**
     * @var Repository The repository instance.
     */
    protected $repository;

    /**
     * BaseService constructor.
     *
     * @param Repository $repository The repository instance.
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve and paginate a list of records.
     *
     * @param  array    $data An array of parameters for filtering, sorting, and pagination
     * @return iterable The paginated result set
     */
    public function index(array $data): iterable
    {
        return $this->repository
            ->search($data['search'] ?? '')
            ->order($data['column'] ?? 'id', $data['direction'] ?? 'asc')
            ->paginate($data['paginate'] ?? 10);
    }

    /**
     * Create a new record.
     *
     * @param  array  $data The data for creating the new record
     * @return object The newly created record
     */
    public function store(array $data): object
    {
        return $this->repository->create($data);
    }

    /**
     * Retrieve a specific record by its ID or UUID.
     *
     * @param  int|string $id The ID or UUID of the record to retrieve
     * @return object     The retrieved record
     * @throws \Exception If the record is not found
     */
    public function show(int|string $id): object
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Update an existing record.
     *
     * @param  int|string $id   The ID or UUID of the record to update
     * @param  array      $data The data for updating the record
     * @return bool       True if the update was successful
     * @throws \Exception If the record is not found
     */
    public function update(int|string $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a specific record.
     *
     * @param  int|string $id The ID or UUID of the record to delete
     * @return bool       True if the deletion was successful
     * @throws \Exception If the record is not found
     */
    public function destroy(int|string $id): bool
    {
        return $this->repository->delete($id);
    }
}
