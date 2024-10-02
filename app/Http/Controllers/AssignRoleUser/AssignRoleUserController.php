<?php

// app/Http/Controllers/AssignRoleUserController.php
namespace App\Http\Controllers\AssignRoleUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRoleUser\AssignRoleUserRequest;
use App\Http\Resources\AssignRoleUser\AssignRoleUserResource;
use App\Services\AssignRoleUser\AssignRoleUserService;

/**
 * Class AssignRoleUserController
 * @package App\Http\Controllers\AssignRoleUser
 */
class AssignRoleUserController extends Controller
{
    /**
     * @var AssignRoleUserService
     */
    protected $userRoleAssignService;

    /**
     * AssignRoleUserController constructor.
     * @param AssignRoleUserService $userRoleAssignService
     */
    public function __construct(AssignRoleUserService $userRoleAssignService)
    {
        $this->userRoleAssignService = $userRoleAssignService;
    }

    /**
     * Get userRoleAssign by id
     * @param $id
     * @return AssignRoleUserResource
     */
    public function get($id)
    {
        $userRoleAssigns = $this->userRoleAssignService->getAssignRoleUserById($id);
        return new AssignRoleUserResource($userRoleAssigns);
    }

    /**
     * Get all userRoleAssigns
     *
     * @param AssignRoleUserRequest $request
     * @return AssignRoleUserResource
     */
    public function all(AssignRoleUserRequest $request)
    {
        $userRoleAssigns = $this->userRoleAssignService->getAllUserAssignRoleUser($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return AssignRoleUserResource::collection($userRoleAssigns);
        }
        
        return AssignRoleUserResource::collection($userRoleAssigns);
    }

    /**
     * Create new userRoleAssign
     * @param AssignRoleUserRequest $request
     * @return AssignRoleUserResource
     */
    public function create(AssignRoleUserRequest $request)
    {
        $userRoleAssign = $this->userRoleAssignService->createAssignRoleUser($request);

        return new AssignRoleUserResource($userRoleAssign);
    }

    /**
     * Update userRoleAssign
     * @param AssignRoleUserRequest $request
     * @param $id
     * @return AssignRoleUserResource
     */
    public function update(AssignRoleUserRequest $request, $id)
    {
        $userRoleAssign =  $this->userRoleAssignService->updateAssignRoleUser($id, $request);
        return new AssignRoleUserResource($userRoleAssign);
    }

    /**
     * Delete userRoleAssign
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->userRoleAssignService->deleteAssignRoleUser($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'AssignRoleUser deleted successfully.',
        ], 200);
    }
    

  
}

