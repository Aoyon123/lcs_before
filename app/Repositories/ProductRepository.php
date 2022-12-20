<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\CrudInterface;
use Illuminate\Contracts\Pagination\Paginator;

class ProductRepository implements CrudInterface
{
public function getAll():Paginator{
        return Product::paginate(10);
}

public function getById(int $id):Product{
    return Product::find($id);
}
}
