<?php

namespace Project\Repositories;

use Core\Model;

interface ICrudRepository
{
    public function getPaginated(): array;

    public function create(array $attributes);

    public function findOne($id);

    public function update(Model $model, array $attributes): bool;

    public function delete(Model $model): bool;
}