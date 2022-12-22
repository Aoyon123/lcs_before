<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\CrudInterface;
use Illuminate\Contracts\Pagination\Paginator;

class ProductRepository implements CrudInterface
{
public function getAll(?int $perpage=10):Paginator{
        return Product::paginate($perpage);
}

public function getById(int $id):Product{
    return Product::find($id);
}
}
