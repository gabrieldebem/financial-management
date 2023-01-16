<?php

namespace App\Repositories;

use App\Repositories\DTOs\DtoInterface;

abstract class AbstractRepository
{
    public $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function resolveModel()
    {
        return app($this->model);
    }

    public function create(DtoInterface $data)
    {
        return $this->model->create($data->toArray());
    }

    public function update(DtoInterface $data, string $id)
    {
        $record = $this->model->find($id);
        $record->update($data->toArray());

        return $record;
    }
}
