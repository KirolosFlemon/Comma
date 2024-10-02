<?php

// app/Repositories/BrandRepository.php
namespace App\Repositories\Brand;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandRepository
{
    /**
     * Retrieves all brands with pagination if specified.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection The collection of brands.
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Brand::with('images')->paginate($is_paginate);
        }
        return Brand::with('images')->get();
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function create($request)
    {
        return Brand::create($request);
    }

    /**
     * Retrieves a specific brand by its ID.
     *
     * @param int $id The ID of the brand to retrieve.
     * @throws ModelNotFoundException if the brand with the given ID is not found.
     * @return Brand The brand object with the specified ID.
     */
    public function find($id)
    {
        return Brand::findOrFail($id);
    }

    /**
     * Updates a brand by its ID with the provided request data.
     *
     * @param int $id The ID of the brand to update.
     * @param mixed $request The request data for updating the brand.
     * @return Brand The updated brand object.
     */
    public function update($id, $request)
    {
        $brand = $this->find($id);
        $brand->update($request);
        return $brand;
    }

    /**
     * Deletes a brand by its ID.
     *
     * @param int $id The ID of the brand to delete.
     * @throws ModelNotFoundException if the brand with the given ID is not found.
     * @return void
     */
    public function delete($id)
    {
        $brand = $this->find($id);
        $brand->delete();
    }
    
     /**
     * Retrieves soft deleted records from the brand repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated brand of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the brand repository.
        // Only retrieves 15 records at a time.
        return Brand::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted brand.
     *
     * @param int $id The ID of the brand to restore.
     * @throws ModelNotFoundException if the brand with the given ID is not found.
     * @return bool Returns true if the brand is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the brand with the given ID
     $brand = Brand::withTrashed()->findOrFail($id);
    
     // Restore the brand and return the result
     return $brand->restore();
    }
}
