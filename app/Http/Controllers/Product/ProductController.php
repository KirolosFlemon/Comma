<?php

// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function get($id)
    {
        $products = $this->productService->getProductById($id);
        return new ProductResource($products->load('categories','collections','branches','brand','variants','variants.sizes','variants.material'));
    }
    
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function all(ProductRequest $request)
    {
        $products = $this->productService->getAllProducts($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return ProductResource::collection($products);

        }
        // return SizeResource::collection($sizes);
        return ProductResource::collection($products->load('categories','collections','branches','brand','variants','variants.sizes','variants.material'));
    }

    /**
     * Creates a new product using the provided ProductRequest object and returns a new ProductResource object.
     *
     * @param ProductRequest $request The ProductRequest object containing the data for the new product.
     * @return ProductResource The newly created ProductResource object.
     */
    public function create(ProductRequest $request)
    {
        // dd($request->all());
        $product = $this->productService->createProduct($request);
        
        return new ProductResource($product->load('categories','collections','branches','brand','variants','variants.color','variants.sizes','variants.material','variants.size'));
    }


    /**
     * Updates a product based on the provided request and ID.
     *
     * @param ProductRequest $request The request containing the updated product data
     * @param int $id The ID of the product to update
     * @return ProductResource The resource representing the updated product with city and user details loaded
     */
    public function update(ProductRequest $request, $id)
    {
        // dd($request->all());
        $product =  $this->productService->updateProduct($id, $request);
        return new ProductResource($product->load('categories','collections','branches','brand','variants','variants.color','variants.sizes','variants.material','variants.size'));
    }

    /**
     * Deletes a product by its ID.
     *
     * @param int $id The ID of the product to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response with a success message and data.
     */
    public function delete($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Product deleted successfully.',
        ], 200);
    }
}
