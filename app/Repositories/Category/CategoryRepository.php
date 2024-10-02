<?php

// app/Repositories/CategoryRepository.php
namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository
{
    /**
     * Retrieve all categories with pagination option.
     *
     * @param bool $is_paginate Whether to paginate the results or not.
     * @return mixed The categories with or without pagination.
     */
    public function all($is_paginate)
    {
            if ($is_paginate) {
                return Category::with('images')->paginate($is_paginate);
            }
            return Category::all();
    }

    /**
     * Create a new category with associated images.
     *
     * @param Illuminate\Http\Request $request The request containing the category data.
     * @return App\Models\Category The newly created category with associated images.
     */
    public function create($request)
    {
        return Category::create($request);
    }

    /**
     * Get a category by its ID.
     *
     * @param int $id The ID of the category.
     * @return App\Models\Category The category with the given ID.
     */
    public function find($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Update a category with associated images.
     *
     * @param int $id The ID of the category to update.
     * @param Illuminate\Http\Request $request The request containing the category data.
     * @return App\Models\Category The updated category with associated images.
     */
    public function update($id, $request)
    {
        $category = $this->find($id);
        $category->update($request);
        return $category;
    }

    /**
     * Delete a category by its ID.
     *
     * @param int $id The ID of the category to delete.
     * @return void
     */
    public function delete($id)
    {
        $category = $this->find($id);
        $category->delete();
    }
    
    /**
     * Retrieve soft deleted records from the category repository.
     * Only retrieves 15 records at a time.
     *
     * @return Illuminate\Database\Eloquent\Collection The soft deleted records.
     */
    public function getSoftDeleted()
    {
        return Category::onlyTrashed()->paginate(15);
    }

    /**
     * Restore a soft deleted category by its ID.
     *
     * @param int $id The ID of the category to restore.
     * @return void
     */
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        return $category->restore();
    }
}

