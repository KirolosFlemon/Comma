<?php
// app/Services/RoleService.php
namespace App\Services\Role;

use App\Repositories\Role\RoleRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleService
{
    protected $roleRepository;

    /**
     * Constructor function to initialize the repository
     *
     * @param RoleRepository $roleRepository The role repository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Fetch all roles
     *
     * @return array The list of roles
     */
    public function getAllRoles($is_paginate)
    {
        return $this->roleRepository->all($is_paginate);
    }

    /**
     * Create a new role
     *
     * @param Request $request The request containing the role details
     * @return Role The newly created role
     */
    public function createRole(Request $request)
    {
        try {
            DB::beginTransaction();

            // // Remove all characters except alphabetic characters
            // $roleName = preg_replace('/[^a-zA-Z\s]/', ' ', $request->input('name'));

            // // Capitalize the first letter of each word
            // $roleName = ucwords($roleName);

            // // Remove spaces
            // $roleName = str_replace(' ', '', $roleName);
            $request->merge(['name' => str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z\s]/', ' ', $request->input('name'))))]);

            // Create a new role
            $role = $this->roleRepository->create($request->all());
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
    public function getRoleById($id)
    {
        return $this->roleRepository->find($id);
    }

    /**
     * Update an existing role
     *
     * @param int $id The ID of the role
     * @param Request $request The request containing the updated details
     * @return Role The updated role
     */
    public function updateRole($id, $request)
    {
        try {

        //    // Remove all characters except alphabetic characters
        //    $roleName = preg_replace('/[^a-zA-Z\s]/', ' ', $request->input('name'));

        //    // Capitalize the first letter of each word
        //    $roleName = ucwords($roleName);

        //    // Remove spaces
        //    $roleName = str_replace(' ', '', $roleName);
            $request->merge(['name' => str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z\s]/', ' ', $request->input('name'))))]);

            $role = $this->roleRepository->update($id, $request->all());

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
    public function deleteRole($id)
    {
        $this->roleRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the role repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->roleRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted role by its ID.
     *
     * @param int $id The ID of the role to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the role repository
        // to restore the soft deleted role.
        return $this->roleRepository->restore($id);
    }
}
