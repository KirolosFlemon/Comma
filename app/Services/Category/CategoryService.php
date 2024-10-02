<?php
// app/Services/CategoryService.php
namespace App\Services\Category;

use App\Repositories\Category\CategoryRepository;
use App\Traits\HelperFunctions;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all categories with pagination option.
     *
     * @param bool $is_paginate Whether to paginate the results or not.
     * @return mixed The categories with or without pagination.
     */
    public function getAllCategories($is_paginate)
    {
        return $this->categoryRepository->all($is_paginate);
    }

    /**
     * Create a new category with associated images.
     *
     * @param Illuminate\Http\Request $request The request containing the category data.
     * @return App\Models\Category The newly created category with associated images.
     * @throws \Exception If any operation fails.
     */
    public function createCategory($request)
    {
        try {
            DB::beginTransaction();
            $slug = HelperFunctions::makeSlug($request->name_en) . '-' . HelperFunctions::makeSlug($request->sku);
            $request['slug'] = $slug;
            $category =  $this->categoryRepository->create($request->except('images'));
            // Attach images to the category
            if ($request->images) {
                foreach ($request->images as $image) {
                    $category->images()->create(['image' => $image]);
                }
            }
            // Commit the transaction if all operations are successful
            DB::commit();
            return $category->load('images');
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Get a category by its ID.
     *
     * @param int $id The ID of the category.
     * @return App\Models\Category The category with the given ID.
     */
    public function getCategoryById($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Update a category with associated images.
     *
     * @param int $id The ID of the category to update.
     * @param Illuminate\Http\Request $request The request containing the category data.
     * @return App\Models\Category The updated category with associated images.
     * @throws \Exception If any operation fails.
     */
    public function updateCategory($id, $request)
    {
        try {

            DB::beginTransaction();

            $category = $this->categoryRepository->update($id, $request->except('images'));
            $category->images()->delete();

            if ($request->images) {
                foreach ($request->images as $image) {
                    $category->images()->create(['image' => $image]);
                }
            }
            // Commit the transaction if all operations are successful
            DB::commit();
            return $category;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete a category by its ID.
     *
     * @param int $id The ID of the category to delete.
     * @return void
     */
    public function deleteCategory($id)
    {
        $this->categoryRepository->delete($id);
    }
    
    /**
     * Get all soft deleted records from the category repository.
     *
     * @return Illuminate\Database\Eloquent\Collection The soft deleted records.
     */
    public function getSoftDeleted()
    {
        return $this->categoryRepository->getSoftDeleted();
    }

    /**
     * Restore a soft deleted category by its ID.
     *
     * @param int $id The ID of the category to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the category repository
        // to restore the soft deleted category.
        return $this->categoryRepository->restore($id);
    }
}

