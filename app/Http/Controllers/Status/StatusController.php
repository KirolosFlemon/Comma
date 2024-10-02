<?php

// app/Http/Controllers/StatusController.php
namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;

use App\Http\Requests\Status\StatusRequest;
use App\Http\Resources\Status\StatusResource;
use App\Services\Status\StatusService;


class StatusController extends Controller
{
    protected $statusService;

    /**
     * Constructor for StatusController.
     *
     * @param StatusService $statusService The status service instance.
     * @throws None
     * @return None
     */
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }
    /**
     * Retrieves a status by its ID.
     *
     * @param int $id The ID of the status to retrieve.
     * @throws None
     * @return StatusResource The status resource object.
     */
    public function get($id)
    {
        $statuses = $this->statusService->getStatusById($id);
        return new StatusResource($statuses);
    }
    /**
     * Retrieves all statuses using the status service.
     * 
     * @throws None
     * @return StatusResource The status resource object.
     */
    public function all(StatusRequest $request)
    {
        $statuses = $this->statusService->getAllStatuses($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return StatusResource::collection($statuses);
        }
        return StatusResource::status($statuses);
    }

    /**
     * Creates a new status using the provided StatusRequest object and returns a new StatusResource object.
     *
     * @param StatusRequest $request The StatusRequest object containing the data for the new status.
     * @throws None
     * @return StatusResource The newly created StatusResource object.
     */
    public function create(StatusRequest $request)
    {
        $status = $this->statusService->createStatus($request);

        return new StatusResource($status);
    }


    /**
     * Updates a status using the provided StatusRequest object and returns a new StatusResource object.
     *
     * @param StatusRequest $request The StatusRequest object containing the data for the status update.
     * @param int $id The ID of the status to update.
     * @return StatusResource The updated StatusResource object.
     */
    public function update(StatusRequest $request, $id)
    {
        $status =  $this->statusService->updateStatus($id, $request);
        return new StatusResource($status);
    }

    /**
     * Deletes a status by ID.
     *
     * @param int $id The ID of the status to delete.
     * @throws None
     * @return JSON The JSON response indicating the success of the deletion.
     */
    public function delete($id)
    {
        $this->statusService->deleteStatus($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Status deleted successfully.',
        ], 200);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        $status = $this->statusService->getSoftDeleted();
        return  StatusResource::collection($status);
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function restore($id)
    {
        $this->statusService->restore($id);
        return response()->json([
            'data' => 'Status restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
