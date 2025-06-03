<?php

namespace App\Repositories\BaseRepository\Interfaces;

interface IBaseRepository
{
    public function all(array $columns = ['*']);
    public function paginate(int $perPage = 15);
    public function find(int|string $id);
    public function findBy(array $conditions, array $columns = ['*']);
    public function getByColumn(string $column, int|string $data);
    public function create(array $data);
    public function update(int|string $id, array $data);
    public function delete(int|string $id);

    // Soft Delete
    public function onlyTrashed();
    public function restore(int|string $id);
    public function forceDelete(int|string $id);

    // Transactional
    public function createWithTransaction(array $data);
    public function updateWithTransaction(int|string $id, array $data);

    // Filter & Sort
    public function filterAndSort(array $filters = [], array $sort = []);
}
