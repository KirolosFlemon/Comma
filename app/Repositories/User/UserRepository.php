<?php

// app/Repositories/UserRepository.php
namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository
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
            return User::paginate($is_paginate);
        }
        return User::all();
    }

    /**
     * A description of the entire PHP function.
     *
     * @param Request $request 
     * @throws None
     * @return User The created User object.
     */
    public function create(Request $request)
    {

        return User::create($request->all());
    }

    /**
     * Finds a user by its ID.
     *
     * @param int $id The ID of the user to find.
     * @throws ModelNotFoundException if the user with the given ID is not found.
     * @return User The found user object.
     */
    public function find($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Updates a user by its ID with the provided request data.
     *
     * @param int $id The ID of the user to update.
     * @param mixed $request The request data for updating the user.
     * @return User The updated user object.
     */
    public function update($id, $request)
    {
        $user = $this->find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Deletes a user by its ID.
     *
     * @param int $id The ID of the user to delete.
     * @throws ModelNotFoundException if the user with the given ID is not found.
     * @return void
     */
    public function delete($id)
    {
        $user = $this->find($id);
        $user->delete();
    }

    
    /**
     * Retrieves soft deleted records from the user repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated user of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the user repository.
        // Only retrieves 15 records at a time.
        return User::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted user.
     *
     * @param int $id The ID of the user to restore.
     * @throws ModelNotFoundException if the user with the given ID is not found.
     * @return bool Returns true if the user is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the user with the given ID
     $user = User::withTrashed()->findOrFail($id);
    
     // Restore the user and return the result
     return $user->restore();
    }

}
