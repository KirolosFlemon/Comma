<?php
// app/Services/SubCategory/SubCategoryService.php
namespace App\Services\SubCategory;

use App\Repositories\SubCategory\SubCategoryRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoryService
{
    protected $SubCategoryRepository;

    public function __construct(SubCategoryRepository $SubCategoryRepository)
    {
        $this->SubCategoryRepository = $SubCategoryRepository;
    }

    /**
     * Retrieves all subCategories from the database.
     *
     * @return object[] The list of subCategory objects.
     */
    public function getAllSubCategories($is_paginate)
    {
        // return $this->SubCategoryRepository->all();
        $subCategory =  $this->SubCategoryRepository->all($is_paginate);
        // $subCategory->load('category');
        return $subCategory;
    }

    /**
     * Creates a new subCategory and its associated images and category_ids.
     *
     * @return object The newly created subCategory object.
     */
    public function createSubCategories(Request $request)
    {
        try {
            DB::beginTransaction();
            $slug = HelperFunctions::makeSlug($request->name_en) . '-' . HelperFunctions::makeSlug($request->sku);
            $request['slug'] = $slug;
            // dd($request->all());
            $subCategory =  $this->SubCategoryRepository->create($request->except([
                'category_ids',
                'images'
            ]));

            // Attach images to the subCategory
            if ($request->images) {
                foreach ($request->images as $image) {
                    $subCategory->images()->create(['image' => $image]);
                }
            }

            // Attach category_ids to the subCategory
            if ($request->category_ids) {
                foreach ($request->category_ids as $categoryId) {
                    $subCategory->category()->attach($categoryId);
                }
            }
            // Commit the transaction if all operations are successful
            DB::commit();
            return $subCategory;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a subCategory by its ID.
     *
     * @param int $id The ID of the subCategory to retrieve.
     * @return object The subCategory object.
     */
    public function getSubCategoryById($id)
    {
        $subCategory =  $this->SubCategoryRepository->find($id);
        $subCategory->load('category');
        return $subCategory;
    }

    /**
     * Updates an existing subCategory with its associated images and category_ids.
     *
     * @param int $id The ID of the subCategory to update.
     * @return object The updated subCategory object.
     */
    public function updateSubCategory($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $subCategory = $this->SubCategoryRepository->update($id, $request->except([
                'category_ids',
                'images'
            ]));

            // Attach images to the subCategory
            if ($request->images) {
                foreach ($request->images as $image) {
                    $subCategory->images()->create(['image' => $image]);
                }
            }
            // Sync category_ids to the subCategory

            $subCategory->category()->sync($request->category_ids);


            // Commit the transaction if all operations are successful
            DB::commit();
            return $subCategory;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Deletes a subCategory by its ID.
     *
     * @param int $id The ID of the subCategory to delete.
     * @return void
     */
    public function deleteSubCategory($id)
    {
        $this->SubCategoryRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the subCategory repository.
     *
     * @return object[] The list of soft deleted subCategory objects.
     */
    public function getSoftDeleted()
    {
        return $this->SubCategoryRepository->getSoftDeleted();
    }

    /**
     * Restores a soft deleted subCategory by its ID.
     *
     * @param int $id The ID of the subCategory to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the subCategory repository
        // to restore the soft deleted subCategory.
        return $this->SubCategoryRepository->restore($id);
    }
}
