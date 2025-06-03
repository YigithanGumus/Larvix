<?php

namespace App\Repositories\BaseRepository;

use App\Repositories\BaseRepository\Interfaces\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseRepository implements IBaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function findBy(array $conditions, array $columns = ['*'])
    {
        return $this->model->where($conditions)->get($columns);
    }

    public function delete(int|string $id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function find(int|string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function onlyTrashed()
    {
        return $this->model->onlyTrashed()->get();
    }

    public function restore(int|string $id)
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();
    }

    // 🔁 Soft Delete

    public function forceDelete(int|string $id)
    {
        return $this->model->withTrashed()->findOrFail($id)->forceDelete();
    }

    public function createWithTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->create($data);
        });
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // 💸 Transactional Create/Update

    public function updateWithTransaction(int|string $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->update($id, $data);
        });
    }

    public function update(int|string $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    // 🔍 Filter & Sort

    public function filterAndSort(array $filters = [], array $sort = [])
    {
        $query = $this->model->newQuery();

        foreach ($filters as $field => $value) {
            $query->where($field, $value);
        }

        foreach ($sort as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query->get();
    }

    public function getByColumn(string $column, int|string $data)
    {
        return $this->model->whereLike($column, $data)->first();
    }
}
