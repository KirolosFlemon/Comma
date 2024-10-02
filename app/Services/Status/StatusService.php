<?php
// app/Services/StatusService.php
namespace App\Services\Status;

use App\Repositories\Status\StatusRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusService
{
    protected $statusRepository;

    /**
     * Constructs a new StatusService instance.
     *
     * @param StatusRepository $statusRepository The status repository to be injected.
     * @throws None
     * @return None
     */
    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Retrieves all statuses with optional pagination.
     *
     * @param mixed $is_paginate Flag to determine pagination
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getAllStatuses($is_paginate)
    {
        return $this->statusRepository->all($is_paginate);
    }

    /**
     * Creates a new status using the provided Request object and returns the created status.
     *
     * @param Request $request The Request object containing the data for the new status.
     * @throws Exception If an error occurs during status creation.
     * @return Status The newly created status object.
     */
    public function createStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $status =  $this->statusRepository->create($request);
            // Commit the transaction if all operations are successful
            DB::commit();
            return $status;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a specific collection by its ID.
     *
     * @param int $id The ID of the collection to retrieve.
     * @throws ModelNotFoundException if the collection with the given ID is not found.
     * @return Collection The collection object with the specified ID.
     */
    public function getStatusById($id)
    {
        return $this->statusRepository->find($id);
    }

    /**
     * Updates a status with the provided ID and Request object.
     *
     * @param mixed $id The ID of the status to update.
     * @param Request $request The Request object containing the updated status data.
     * @throws \Exception If an error occurs during status update.
     * @return Status The updated Status object.
     */
    public function updateStatus($id, Request $request)
    {
        try {

            DB::beginTransaction();

            $status = $this->statusRepository->update($id, $request->except('images'));


            // Commit the transaction if all operations are successful
            DB::commit();
            return $status;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Deletes a status by ID.
     *
     * @param int $id The ID of the status to delete.
     * @throws None
     * @return None
     */
    public function deleteStatus($id)
    {
        $this->statusRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the status repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->statusRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted status by its ID.
     *
     * @param int $id The ID of the status to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the status repository
        // to restore the soft deleted status.
        return $this->statusRepository->restore($id);
    }
}
