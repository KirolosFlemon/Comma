<?php

// app/Repositories/BranchRepository.php
namespace App\Repositories\Branch;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchRepository
{
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Branch::paginate($is_paginate);
        }
        return Branch::all();
    }

    /**
     * A description of the entire PHP function.
     *
     * @param Request $request 
     * @throws None
     * @return Branch The created Branch object.
     */
    public function create(Request $request)
    {

        return Branch::create($request->all());
    }

    /**
     * Finds a branch by its ID.
     *
     * @param int $id The ID of the branch to find.
     * @throws ModelNotFoundException if the branch with the given ID is not found.
     * @return Branch The found branch object.
     */
    public function find($id)
    {
        return Branch::findOrFail($id);
    }

    /**
     * Updates a branch by its ID with the provided request data.
     *
     * @param int $id The ID of the branch to update.
     * @param mixed $request The request data for updating the branch.
     * @return Branch The updated branch object.
     */
    public function update($id, $request)
    {
        $branch = $this->find($id);
        $branch->update($request->all());
        return $branch;
    }

    /**
     * Deletes a branch by its ID.
     *
     * @param int $id The ID of the branch to delete.
     * @throws ModelNotFoundException if the branch with the given ID is not found.
     * @return void
     */
    public function delete($id)
    {
        $branch = $this->find($id);
        $branch->delete();
    }

    
    /**
     * Retrieves soft deleted records from the branch repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated branch of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the branch repository.
        // Only retrieves 15 records at a time.
        return Branch::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted branch.
     *
     * @param int $id The ID of the branch to restore.
     * @throws ModelNotFoundException if the branch with the given ID is not found.
     * @return bool Returns true if the branch is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the branch with the given ID
     $branch = Branch::withTrashed()->findOrFail($id);
    
     // Restore the branch and return the result
     return $branch->restore();
    }

}
