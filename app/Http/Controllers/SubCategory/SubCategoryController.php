<?php

// app/Http/Controllers/SubCategoryController.php
namespace App\Http\Controllers\SubCategory;

use App\Http\Controllers\Controller;

use App\Http\Requests\SubCategory\SubCategoryRequest;
use App\Http\Resources\SubCategory\SubCategoryResource;
use App\Services\SubCategory\SubCategoryService;


class SubCategoryController extends Controller
{
    protected $SubCategoryService;

    public function __construct(SubCategoryService $SubCategoryService)
    {
        $this->SubCategoryService = $SubCategoryService;
    }
    /**
     * Get a sub category by id
     *
     * @param int $id
     * @return SubCategoryResource
     */
    public function get($id)
    {
        $SubCategories = $this->SubCategoryService->getSubCategoryById($id);
        return new SubCategoryResource($SubCategories);
    }
    /**
     * Get all sub categories
     *
     * @param SubCategoryRequest $request
     * @return SubCategoryResource
     */
    public function all(SubCategoryRequest $request)
    {
        $SubCategories = $this->SubCategoryService->getAllSubCategories($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return SubCategoryResource::collection($SubCategories);
        }
        return SubCategoryResource::collection($SubCategories);
    }

    /**
     * Create a new sub category
     *
     * @param SubCategoryRequest $request
     * @return SubCategoryResource
     */
    public function create(SubCategoryRequest $request)
    {
        $SubCategory = $this->SubCategoryService->createSubCategories($request);

        return new SubCategoryResource($SubCategory);
    }

    /**
     * Update a sub category
     *
     * @param SubCategoryRequest $request
     * @param int $id
     * @return SubCategoryResource
     */
    public function update(SubCategoryRequest $request, $id)
    {
        $SubCategory =  $this->SubCategoryService->updateSubCategory($id, $request);
        return new SubCategoryResource($SubCategory);
    }

    /**
     * Delete a sub category
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $this->SubCategoryService->deleteSubCategory($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Sub Category deleted successfully.',
        ], 200);
    }

    /**
     * Get all soft deleted sub categories
     *
     * @return SubCategoryResource
     */
    public function getSoftDeleted()
    {
        $subCategory = $this->SubCategoryService->getSoftDeleted();
        return  SubCategoryResource::collection($subCategory);
    }

    /**
     * Restore a soft deleted sub category
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore($id)
    {
        $this->SubCategoryService->restore($id);
        return response()->json([
            'data' => 'Sub Category restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}

