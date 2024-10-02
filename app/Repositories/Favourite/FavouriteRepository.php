<?php

// app/Repositories/FavouriteRepository.php
namespace App\Repositories\Favourite;

use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteRepository
{
    /**
     * Retrieves all favourites with pagination if specified.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection The collection of favourites.
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Favourite::with('user','product')->paginate($is_paginate);
        }
        return Favourite::with('user','product')->get();
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
        return Favourite::create($request);
    }

    /**
     * Retrieves a specific favourite by its ID.
     *
     * @param int $id The ID of the favourite to retrieve.
     * @throws ModelNotFoundException if the favourite with the given ID is not found.
     * @return Favourite The favourite object with the specified ID.
     */
    public function find($id)
    {
        return Favourite::findOrFail($id);
    }

    /**
     * Updates a favourite by its ID with the provided request data.
     *
     * @param int $id The ID of the favourite to update.
     * @param mixed $request The request data for updating the favourite.
     * @return Favourite The updated favourite object.
     */
    public function update($id, $request)
    {
        $favourite = $this->find($id);
        $favourite->update($request);
        return $favourite;
    }

    /**
     * Deletes a favourite by its ID.
     *
     * @param int $id The ID of the favourite to delete.
     * @throws ModelNotFoundException if the favourite with the given ID is not found.
     * @return void
     */
    public function delete($id)
    {
        $favourite = $this->find($id);
        $favourite->delete();
    }
    
     /**
     * Retrieves soft deleted records from the favourite repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated favourite of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the favourite repository.
        // Only retrieves 15 records at a time.
        return Favourite::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted favourite.
     *
     * @param int $id The ID of the favourite to restore.
     * @throws ModelNotFoundException if the favourite with the given ID is not found.
     * @return bool Returns true if the favourite is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the favourite with the given ID
     $favourite = Favourite::withTrashed()->findOrFail($id);
    
     // Restore the favourite and return the result
     return $favourite->restore();
    }
}
