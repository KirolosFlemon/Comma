<?php

// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    /**
     * Create a new controller instance.
     *
     * @param  CategoryService  $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get a category by id
     *
     * @param  int  $id
     * @return CategoryResource
     */
    public function get($id)
    {
        $categories = $this->categoryService->getCategoryById($id);
        return new CategoryResource($categories->load('images'));
    }

    /**
     * Get all categories
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(CategoryRequest $request)
    {
        $categories = $this->categoryService->getAllCategories($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return CategoryResource::collection($categories);
        }
        return CategoryResource::collection($categories->load('images'));
    }

    /**
     * Create a new category
     *
     * @param  CategoryRequest  $request
     * @return CategoryResource
     */
    public function create(CategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request);

        return new CategoryResource($category);
    }

    /**
     * Update a category
     *
     * @param  CategoryRequest  $request
     * @param  int  $id
     * @return CategoryResource
     */
    public function update(CategoryRequest $request, $id)
    {
        $category =  $this->categoryService->updateCategory($id, $request);
        return new CategoryResource($category->load('images'));
    }

    /**
     * Delete a category
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->categoryService->deleteCategory($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Category deleted successfully.',
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
        $category = $this->categoryService->getSoftDeleted();
        return  CategoryResource::collection($category);
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
        $this->categoryService->restore($id);
        return response()->json([
            'data' => 'Category restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}

