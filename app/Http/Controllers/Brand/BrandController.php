<?php

// app/Http/Controllers/BrandController.php
namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;

use App\Http\Requests\Brand\BrandRequest;
use App\Http\Resources\Brand\BrandResource;
use App\Services\Brand\BrandService;


class BrandController extends Controller
{
    protected $brandService;

    /**
     * A constructor for the BrandController class.
     *
     * @param BrandService $brandService The brand service instance to be injected.
     * @throws \Exception if an error occurs during instantiation
     * @return void
     */
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Retrieves a specific brand by its ID.
     *
     * @param int $id The ID of the brand to retrieve.
     * @return BrandResource The brand resource object.
     */
    public function get($id)
    {
        $brands = $this->brandService->getBrandById($id);
        return new BrandResource($brands->load('images'));
    }
    
    /**
     * Retrieves all brands using the brand service.
     *
     * @return BrandResource
     */
    public function all(BrandRequest $request)
    {
        $brands = $this->brandService->getAllBrands($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {

            return BrandResource::collection($brands);
        }
        return BrandResource::collection($brands->load('images'));
    }

    /**
     * Creates a new brand using the provided request.
     *
     * @param BrandRequest $request The request containing brand information.
     * @return BrandResource The newly created brand resource.
     */
    public function create(BrandRequest $request)
    {
        $brand = $this->brandService->createBrand($request);
        
        return new BrandResource($brand);
    }


    /**
     * A description of the entire PHP function.
     *
     * @param BrandRequest $request description
     * @param $id description
     * @throws Some_Exception_Class description of exception
     * @return BrandResource description
     */
    public function update(BrandRequest $request, $id)
    {
        $brand =  $this->brandService->updateBrand($id, $request);
        return new BrandResource($brand->load('images'));
    }

    /**
     * Deletes a brand by its ID.
     *
     * @param int $id The ID of the brand to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success.
     */
    public function delete($id)
    {
        $this->brandService->deleteBrand($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Brand deleted successfully.',
        ], 200);
    }

    
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
         $brand = $this->brandService->getSoftDeleted();
        return  BrandResource::collection($brand);
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function restore($id)
    {
        $this->brandService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
