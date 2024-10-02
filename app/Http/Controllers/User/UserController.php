<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        $useres = $this->userService->getUserById($id);
        return new UserResource($useres);
    }
    /**
     * Retrieves all useres using the user service.
     *
     * @return UserResource
     */
    public function all(UserRequest $request)
    {
        $useres = $this->userService->getAllUsers($request->is_paginate ?? 0);
        if (isset($request->is_paginate ) && $request->is_paginate  != 0) {
            return UserResource::collection($useres);
        }
        return UserResource::collection($useres);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param UserRequest $request 
     * @throws None
     * @return UserResource
     */
    public function create(UserRequest $request)
    {
        $user = $this->userService->createUser($request);
        
        return new UserResource($user);
    }


    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function update(UserRequest $request, $id)
    {
        $user =  $this->userService->updateUser($id, $request);
        return new UserResource($user);
    }

    /**
     * Deletes a user by its ID.
     *
     * @param int $id The ID of the user to delete.
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function delete($id)
    {
        $this->userService->deleteUser($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'User deleted successfully.',
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
         $user = $this->userService->getSoftDeleted();
        return  UserResource::collection($user);
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
        $this->userService->restore($id);
        return response()->json([
            'data' => 'User restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
