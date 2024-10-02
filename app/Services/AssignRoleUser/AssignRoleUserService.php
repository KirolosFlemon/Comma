<?php
// app/Services/RoleService.php
namespace App\Services\AssignRoleUser;

use App\Repositories\AssignRoleUser\AssignRoleUserRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssignRoleUserService
{
    protected $AssignRoleUserRepository;

    /**
     * Constructor function to initialize the repository
     *
     * @param AssignRoleUserRepository $roleRepository The role repository
     */
    public function __construct(AssignRoleUserRepository $AssignRoleUserRepository)
    {
        $this->AssignRoleUserRepository = $AssignRoleUserRepository;
    }

    /**
     * Fetch all roles
     *
     * @return array The list of roles
     */
    public function getAllUserAssignRoleUser($is_paginate)
    {
        return $this->AssignRoleUserRepository->all($is_paginate);
    }

    /**
     * Create a new role
     *
     * @param Request $request The request containing the role details
     * @return Role The newly created role
     */
    public function createAssignRoleUser(Request $request)
    {
        try {
            DB::beginTransaction();

            // Create a new role
            $role = $this->AssignRoleUserRepository->create($request->all());
            // Attach permissions to the role
        
            // Commit the transaction if all operations are successful
            DB::commit();
            return $role;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Fetch an role by its ID
     *
     * @param int $id The ID of the role
     * @return Role The role corresponding to the ID
     */
    public function getAssignRoleUserById($id)
    {
        return $this->AssignRoleUserRepository->find($id);
    }

    /**
     * Update an existing role
     *
     * @param int $id The ID of the role
     * @param Request $request The request containing the updated details
     * @return Role The updated role
     */
    public function updateAssignRoleUser($id, $request)
    {
        try {
            DB::beginTransaction();
            $role = $this->AssignRoleUserRepository->update($id, $request->all());

            // Commit the transaction if all operations are successful
            DB::commit();
            return $role;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete an role by its ID
     *
     * @param int $id The ID of the role
     * @return void
     */
    public function deleteAssignRoleUser($id)
    {
        $this->AssignRoleUserRepository->delete($id);
    }


}
