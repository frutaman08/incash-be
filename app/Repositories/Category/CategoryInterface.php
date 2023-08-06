<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryInterface {
    public function index($parameter): LengthAwarePaginator;
    public function show($id): Category;
    public function store($data);
    public function update($data);
    public function delete($id);
}