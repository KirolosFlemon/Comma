<?php

// app/Repositories/CollectionRepository.php
namespace App\Repositories\Collection;

use App\Models\Collection;

class CollectionRepository
{
    /**
     * Retrieves all collections with images, optionally paginated.
     *
     * @param mixed $is_paginate Indicates if the collections should be paginated.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Collection::with('images')->paginate($is_paginate);
        }
        return Collection::with('images')->get();
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
        return Collection::create($request);
    }

    /**
     * Retrieves a specific collection by its ID.
     *
     * @param int $id The ID of the collection to retrieve.
     * @throws ModelNotFoundException if the collection with the given ID is not found.
     * @return Collection The collection object with the specified ID.
     */
    public function find($id)
    {
        return Collection::findOrFail($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function update($id, $request)
    {
        $collection = $this->find($id);
        $collection->update($request);
        return $collection;
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function delete($id)
    {
        $collection = $this->find($id);
        $collection->delete();
    }

    /**
     * Retrieves soft deleted records from the collection repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated collection of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the collection repository.
        // Only retrieves 15 records at a time.
        return Collection::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted collection.
     *
     * @param int $id The ID of the collection to restore.
     * @throws ModelNotFoundException if the collection with the given ID is not found.
     * @return bool Returns true if the collection is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the collection with the given ID
     $collection = Collection::withTrashed()->findOrFail($id);
    
     // Restore the collection and return the result
     return $collection->restore();
    }

    
}
