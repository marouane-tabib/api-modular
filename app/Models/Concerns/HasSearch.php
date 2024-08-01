<?php

namespace App\Models\Concerns;

use App\Models\Model;

trait HasSearch
{
    protected $search = [];

    public function search($value = ""): ?Model
    {
        if (!empty($this->search) && is_array($this->search)) {
            if (!empty($this->search['columns']) && is_array($this->search['columns'])) {
                return $this->when(isset($this->search['columns']), function ($q) use ($value) {
                    foreach ($this->search['columns'] as $column) {
                        if (!empty($column)) {
                            $q->orWhere($column, 'like', "%$value%");
                        } else {
                            throw new \Exception("You must add searchable column for the query");
                        }
                    }
                });
            } else {
                throw new \Exception("You must specify searchable columns for the query");
            }
        }
    }
}