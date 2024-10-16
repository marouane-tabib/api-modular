<?php

namespace App\Services\BaseService;

use App\Repositories\BaseRepository\Interfaces\Repository;
use App\Services\BaseService\Interfaces\Service;
class BaseService implements Service
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function index(array $data): mixed
    {
        return $this->repository
            ->search($data['search'] ?? '')
            ->order($data['column'] ?? 'id', $data['direction'] ?? 'asc')
            ->paginate($data['paginate'] ?? 10);
    }

    public function store(array $data): mixed
    {
        return $this->repository->create($data);
    }

    public function show(int $id): mixed
    {
        return $this->repository->findOrFail($id);
    }

    public function update(int $id, array $data): ?int
    {
        return $this->repository->update($id, $data);
    }

    public function destroy(int $id): ?bool
    {
        return $this->repository->delete($id);
    }
}
