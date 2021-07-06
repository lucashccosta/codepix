<?php

namespace App\Repositories;

use App\Repositories\Contracts\IBaseRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IBaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->makeModel();
    }
    
    abstract public function model();

    protected function makeModel()
    {
        $model = app()->make($this->model());
        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function find(string $id, array $columns = ['*'])
    {
        return $this->model
            ->select($columns)
            ->findOrFail($id);
    }

    public function findOne(array $where, array $columns = ['*'])
    {
        return $this->model
            ->select($columns)
            ->where($where)
            ->firstOrFail();
    }

    public function findWhere(array $where, array $columns = ['*'])
    {
        return $this->model
            ->select($columns)
            ->where($where)
            ->get();
    }

    public function create(array $data)
    {
        $model = $this->model->newInstance($data);
        $model->save();
        return $model;
    }

    public function update($id, array $data)
    {
        $model =  $this->model->findOrFail($id);
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function increment($id, string $column, float $value)
    {
        return $this->model
            ->findOrFail($id)
            ->increment($column, $value);
    }
} 