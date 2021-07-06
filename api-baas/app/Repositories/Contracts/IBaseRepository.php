<?php

namespace App\Repositories\Contracts;

interface IBaseRepository
{
    public function find(string $id, array $columns = ['*']);
    public function findOne(array $where, array $columns = ['*']);
    public function findWhere(array $where, array $columns = ['*']);
    public function create(array $data);
    public function update(string $id, array $data);
    public function increment($id, string $column, float $value);
}
