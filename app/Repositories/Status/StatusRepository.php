<?php

// app/Repositories/StatusRepository.php
namespace App\Repositories\Status;

use App\Models\Status;

class StatusRepository
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
            return Status::paginate($is_paginate);
        }
        return Status::all();
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

        return Status::create($request->all());
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function find($id)
    {
        return Status::findOrFail($id);
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
        $status = $this->find($id);
        $status->update($request);
        return $status;
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
        $status = $this->find($id);
        $status->delete();
    }

     /**
     * Retrieves soft deleted records from the status repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated status of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the status repository.
        // Only retrieves 15 records at a time.
        return Status::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted status.
     *
     * @param int $id The ID of the status to restore.
     * @throws ModelNotFoundException if the status with the given ID is not found.
     * @return bool Returns true if the status is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the status with the given ID
     $status = Status::withTrashed()->findOrFail($id);
    
     // Restore the status and return the result
     return $status->restore();
    }
}
