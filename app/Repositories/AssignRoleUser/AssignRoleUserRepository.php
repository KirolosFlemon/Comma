<?php

// app/Repositories/AssignRoleUserRepository.php
namespace App\Repositories\AssignRoleUser;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignRoleUserRepository
{
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Role::with('users')->paginate($is_paginate);
        }
        return Role::with('users')->get();
    }

    public function create($request)
    {
        // Retrieve user and role from request

        $user = User::findOrFail($request['user_id']); // Retrieve the user by ID
        $role = Role::findOrFail($request['role_id']); // Retrieve the role by ID

        $user->assignRole($role); // Assign the role to the user

        // Return the user with the role and permission
        return $role->load('users')->toArray();
    }

    public function find($id)
    {
        return Role::with('users')->findOrFail($id);
    }

    public function update($id, $request)
    {
        $user = User::findOrFail($request['user_id']); // Retrieve the user by ID
        $role = Role::findOrFail($id); // Retrieve the role by ID
        $role->users()->sync([$user->id]); // Sync the user with the role
        return $role;
    }

    public function delete($id)
    {
        $role = $this->find($id);
        $role->delete();
    }

}
