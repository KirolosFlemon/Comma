<?php
// app/Services/ProductService.php
namespace App\Services\Product;

use App\Models\SizeVariant;
use App\Repositories\Product\ProductRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts($is_paginate)
    {
        return $this->productRepository->all($is_paginate);
    }

    /**
     * Creates a new product based on the provided request data.
     *
     * @param Request $request The request containing product data.
     * @throws \Exception If any operation fails during product creation.
     * @return mixed The newly created product.
     */
    public function createProduct(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['images', 'categories', 'collections', 'branches', 'variants']);
            $product =  $this->productRepository->create($data);
            // dd($request->images);
            if ($request->images) {
                foreach ($request->images as $image) {
                    $product->images()->create(['image' => $image]);
                }
            }

            if ($request->categories) {
                $product->categories()->sync($request->categories);
            }

            if ($request->collections) {
                $product->collections()->sync($request->collections);
            }

            if ($request->branches) {
                $product->branches()->sync($request->branches);
            }

            if ($request->variants) {
                foreach ($request->variants as $variant) {
                    $variants = $product->variants()->create(Arr::except($variant, 'size_id'));
                    //    $variant =  $product->variants()->create($variant);
                    if ($variant['size_id']) {
                        foreach ($variant['size_id'] as $size) {
                            $sizeVariant = SizeVariant::create([
                                'size_id' => $size,
                                'variant_id' => $variants->id
                            ]);
                        }
                    }
                }
            }

            // Commit the transaction if all operations are successful
            DB::commit();
            return $product;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }

    public function updateProduct($id, $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->except(['images', 'categories', 'collections', 'branches', 'variants']);
            $product = $this->productRepository->update($id, $data);
            if ($request->images) {
                // $product->images()->delete();
                $product->images()->whereNotIn('id', $request->old_images)->delete();

                foreach ($request->images as $image) {
                    $product->images()->create(['image' => $image]);
                }
            }

            if ($request->categories) {
                $product->categories()->sync($request->categories);
            }

            if ($request->collections) {
                $product->collections()->sync($request->collections);
            }

            if ($request->branches) {
                $product->branches()->sync($request->branches);
            }

            if ($request->variants) {
                $product->variants()->delete();
                foreach ($request->variants as $variant) {
                            // $product->variants()->create($variant);

                    $variants = $product->variants()->create(Arr::except($variant, 'size_id'));
                    if ($variant['size_id']) {
                        foreach ($variant['size_id'] as $size) {
                            SizeVariant::where('variant_id', $variants->id)->delete();
                            $sizeVariant = SizeVariant::create([
                                'size_id' => $size,
                                'variant_id' => $variants->id
                            ]);
                        }
                    }
                }
            }

            // Commit the transaction if all operations are successful
            DB::commit();
            return $product;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Deletes a product by its ID.
     *
     * @param int $id The ID of the product to delete.
     * @throws None
     * @return None
     */
    public function deleteProduct($id)
    {
        $this->productRepository->delete($id);
    }
}
