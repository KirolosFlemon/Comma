<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'user']);

        // Create permission for all controllers
        $permissions = [
           
            'address' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'branch' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'brand' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'category' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'color' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'collection' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'material' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'product' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'size' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'subCategory' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'status' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ],
            'slider' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
            ],
            'contact-information' => [
                'all',
                'get',
                'create',
                'update',
                'destroy',
                'restore',
                'getSoftDeleted',
            ]
      
        ];
        

        foreach ($permissions as $controller => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => $controller . ' ' . $action],
                    ['guard_name' => 'api']
                );
            }
        }
        // \Str::title('MiKhail_Rakhimov-EnG'); // MiKhail Rakhimov Eng
        // Assign permissions to roles
        $role1->givePermissionTo(
            Permission::all()->whereNotIn('name', function ($query) use ($permissions) {
                $query->where(function ($query) use ($permissions) {
                    foreach ($permissions as $controller => $actions) {
                        foreach ($actions as $action) {
                            $query->orWhere('name', function ($query) use ($controller, $action) {
                                $query->where('name', "{$controller}::{action}");
                            });
                        }
                    }
                });
            })
        );
        $role2->givePermissionTo(
            Permission::all()->whereIn('name', function ($query) use ($permissions) {
                $query->whereIn('name', function ($query) use ($permissions) {
                    foreach ($permissions['User'] as $action) {
                        $query->where('name', 'User {action}');
                    }
                })->orWhereIn('name', function ($query) use ($permissions) {
                    foreach ($permissions['User'] as $action) {
                        $query->where('name', 'User{action}');
                    }
                })->orWhereIn('name', function ($query) use ($permissions) {
                    foreach ($permissions as $controller => $actions) {
                        foreach ($actions as $action) {
                            $query->orWhere('name', function ($query) use ($controller, $action) {
                                $query->where('name', "{$controller} {action}");
                            });
                        }
                    }
                });
            })
        );
    }
}

