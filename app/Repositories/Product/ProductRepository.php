<?php

// app/Repositories/ProductRepository.php
namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository
{
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Product::with(['categories','collections','branches','brand','variants','variants.color','variants.sizes','variants.material','variants.size'])->paginate($is_paginate);
        }
        return Product::all();
    }

    public function create($request)
    {
        return Product::create($request);
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function update($id, $request)
    {
        $product = $this->find($id);
        $product->update($request);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        $product->delete();
    }
}
