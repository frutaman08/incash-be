<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryInterface {
    private $model;
    
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function index($parameter): LengthAwarePaginator 
    {
        return $this->model
            ->where('name', 'LIKE', '%'.$parameter['search'].'%')
            ->onlyMyCategory()
            ->orderBy($parameter['orderBy'], $parameter['orderDirection'])
            ->paginate($parameter['perPage']);
    }

    public function show($id): Category 
    {
        return $this->model->findOrFail($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function update($data)
    {
        return $this->model->where('id', $data['id'])->update($data);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}