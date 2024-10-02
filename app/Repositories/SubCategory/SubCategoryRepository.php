<?php

// app/Repositories/CategoryRepository.php
namespace App\Repositories\SubCategory;

use App\Models\SubCategory;

class SubCategoryRepository
{
    /**
     * Retrieves all subCategory from the subCategory repository.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of all subCategory.
     */
    public function all($is_paginate)
    {
        if ($is_paginate) {
            return SubCategory::with(['category','images'])->paginate($is_paginate);
        }

        return SubCategory::with(['category','images'])->get();
    }
    /**
     * Creates a new subCategory based on the given request data.
     *
     * @param array $request The request data containing the data to create the subCategory.
     * @return \Illuminate\Database\Eloquent\Model The newly created subCategory.
     */
    public function create($request)
    {
        return SubCategory::create($request);
    }

    /**
     * Finds a subCategory with the given ID.
     *
     * @param int $id The ID of the subCategory to find.
     * @return \Illuminate\Database\Eloquent\Model The found subCategory.
     * @throws ModelNotFoundException If the subCategory with the given ID is not found.
     */
    public function find($id)
    {
        return SubCategory::with('category')->findOrFail($id);
    }
    /**
     * Updates a subCategory with the given ID based on the given request data.
     *
     * @param int $id The ID of the subCategory to update.
     * @param array $request The request data containing the data to update the subCategory.
     * @return \Illuminate\Database\Eloquent\Model The updated subCategory.
     */
    public function update($id, $request)
    {
        $subCategory = $this->find($id);
        $subCategory->update($request);
        return $subCategory;
    }

    /**
     * Deletes a subCategory with the given ID.
     *
     * @param int $id The ID of the subCategory to delete.
     */
    public function delete($id)
    {
        $subCategory = $this->find($id);
        $subCategory->delete();
    }

    /**
     * Retrieves soft deleted records from the subCategory repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated subCategory of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the subCategory repository.
        // Only retrieves 15 records at a time.
        return SubCategory::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted subCategory.
     *
     * @param int $id The ID of the subCategory to restore.
     * @throws ModelNotFoundException if the subCategory with the given ID is not found.
     * @return bool Returns true if the subCategory is successfully restored, false otherwise.
     */
    public function restore($id)
    {
        // Find the subCategory with the given ID
        $subCategory = SubCategory::withTrashed()->findOrFail($id);

        // Restore the subCategory and return the result
        return $subCategory->restore();
    }
}

