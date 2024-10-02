<?php

// app/Repositories/RoleRepository.php
namespace App\Repositories\Role;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Role Repository
 *
 * This class is responsible for interacting with the roles in the database.
 */
class RoleRepository
{
    /**
     * Retrieves all roles from the database
     *
     * @param bool $is_paginate Whether to paginate the results or not.
     * @return \Illuminate\Pagination\Paginator|\Illuminate\Support\Collection A collection of roles.
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Role::paginate($is_paginate);
        }
        return Role::get();
    }

    /**
     * Creates a new role from the provided request data
     *
     * @param \Illuminate\Http\Request $request The request containing the role data.
     * @return array A collection of roles.
     */
    public function create($request)
    {
        // Retrieve user and role from request
        // $user = User::findOrFail($request->user_id);
        $role = Role::create(['name' => $request['name']]);
        // $user->assignRole($role);
        // If permissions are provided, assign them to the role
        $permissions = Permission::whereIn('id', $request['permissions'])->get();
        $role->givePermissionTo($permissions);

        // Return the user with the role and permission
        return $role->load('permissions')->toArray();
    }

    /**
     * Finds a role by its ID
     *
     * @param int $id The ID of the role to find.
     * @return Role The role with the given ID.
     */
    public function find($id)
    {
        return Role::findOrFail($id);
    }

    /**
     * Updates a role with the provided request data
     *
     * @param int $id The ID of the role to update.
     * @param \Illuminate\Http\Request $request The request containing the role data.
     * @return Role The updated role.
     */
    public function update($id, $request)
    {
        $role = $this->find($id);
        $role->update(['name' => $request['name']]);
        // Synchronize permissions if provided
        if (isset($request['permissions'])) {
            $permissions = Permission::whereIn('id', $request['permissions'])
                ->where('guard_name', 'api')
                ->get();
            if ($permissions->count() != count($request['permissions'])) {
                // You can throw an exception or handle it as needed
                throw new \Exception("Some permissions are not found or belong to a different guard.");
            }

            $role->syncPermissions($permissions);
        }
        return $role;
    }

    /**
     * Deletes a role by its ID
     *
     * @param int $id The ID of the role to delete.
     */
    public function delete($id)
    {
        $role = $this->find($id);
        $role->delete();
    }

    /**
     * Retrieves soft deleted roles from the database
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated role of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the role repository.
        // Only retrieves 15 records at a time.
        return Role::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted role
     *
     * @param int $id The ID of the role to restore
     * @throws ModelNotFoundException If the role with the given ID is not found
     * @return bool Returns true if the role is successfully restored, false otherwise
     */
    public function restore($id)
    {
        // Find the role with the given ID
        $role = Role::withTrashed()->findOrFail($id);

        // Restore the role and return the result
        return $role->restore();
    }
}

