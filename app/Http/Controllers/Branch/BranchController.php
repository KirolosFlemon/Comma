<?php

// app/Http/Controllers/BranchController.php
namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;

use App\Http\Requests\Branch\BranchRequest;
use App\Http\Resources\Branch\BranchResource;
use App\Services\Branch\BranchService;


class BranchController extends Controller
{
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function get($id)
    {
        $branches = $this->branchService->getBranchById($id);
        return new BranchResource($branches);
    }
    /**
     * Retrieves all branches using the branch service.
     *
     * @return BranchResource
     */
    public function all(BranchRequest $request)
    {
        $branches = $this->branchService->getAllBranches($request->is_paginate ?? 0);
        if (isset($request->is_paginate ) && $request->is_paginate  != 0) {
            return BranchResource::collection($branches);
        }
        return BranchResource::collection($branches);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param BranchRequest $request 
     * @throws None
     * @return BranchResource
     */
    public function create(BranchRequest $request)
    {
        $branch = $this->branchService->createBranch($request);
        
        return new BranchResource($branch);
    }


    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function update(BranchRequest $request, $id)
    {
        $branch =  $this->branchService->updateBranch($id, $request);
        return new BranchResource($branch);
    }

    /**
     * Deletes a branch by its ID.
     *
     * @param int $id The ID of the branch to delete.
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function delete($id)
    {
        $this->branchService->deleteBranch($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Branch deleted successfully.',
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
         $branch = $this->branchService->getSoftDeleted();
        return  BranchResource::collection($branch);
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
        $this->branchService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
