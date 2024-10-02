<?php

// app/Http/Controllers/RoleController.php
namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\Role\RoleResource;
use App\Services\Role\RoleService;

/**
 * Class RoleController
 * @package App\Http\Controllers\Role
 */
class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * RoleController constructor.
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Get role by id
     * @param $id
     * @return RoleResource
     */
    public function get($id)
    {
        $roles = $this->roleService->getRoleById($id);
        return new RoleResource($roles);
    }

    /**
     * Get all roles
     *
     * @param RoleRequest $request
     * @return RoleResource
     */
    public function all(RoleRequest $request)
    {
        $roles = $this->roleService->getAllRoles($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return RoleResource::collection($roles);
        }
        
        return RoleResource::collection($roles);
    }

    /**
     * Create new role
     * @param RoleRequest $request
     * @return RoleResource
     */
    public function create(RoleRequest $request)
    {
        $role = $this->roleService->createRole($request);

        return new RoleResource($role);
    }

    /**
     * Update role
     * @param RoleRequest $request
     * @param $id
     * @return RoleResource
     */
    public function update(RoleRequest $request, $id)
    {
        $role =  $this->roleService->updateRole($id, $request);
        return new RoleResource($role);
    }

    /**
     * Delete role
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->roleService->deleteRole($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Role deleted successfully.',
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
        $role = $this->roleService->getSoftDeleted();
        return  RoleResource::collection($role);
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
        $this->roleService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}

