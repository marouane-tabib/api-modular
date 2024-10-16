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
     * Retrieve and paginate a list of resources.
     *
     * @param array $data An array of parameters for filtering, sorting, and pagination
     * @return mixed The paginated result set
     */
    public function index(array $data): mixed
    {
        return $this->repository
            ->search($data['search'] ?? '')
            ->order($data['column'] ?? 'id', $data['direction'] ?? 'asc')
            ->paginate($data['paginate'] ?? 10);
    }

    /**
     * Create a new resource.
     *
     * @param array $data The data for creating the new resource
     * @return mixed The newly created resource
     */
    public function store(array $data): mixed
    {
        return $this->repository->create($data);
    }

    /**
     * Retrieve a specific resource by its ID.
     *
     * @param int $id The ID of the resource to retrieve
     * @return mixed The retrieved resource
     */
    public function show(int $id): mixed
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Update an existing resource.
     *
     * @param int $id The ID of the resource to update
     * @param array $data The data for updating the resource
     * @return int|null The number of affected rows or null if the update failed
     */
    public function update(int $id, array $data): ?int
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a specific resource.
     *
     * @param int $id The ID of the resource to delete
     * @return bool|null True if the deletion was successful, false or null otherwise
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->delete($id);
    }
}
