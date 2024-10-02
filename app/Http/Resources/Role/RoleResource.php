<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'], // Accessing 'id' from the array
            'name' => $this['name'], // Accessing 'name' from the array
            'permissions' => collect($this['permissions'])->map(function ($permission) {
                return [
                    'id' => $permission['id'],
                    'name' => $permission['name'],
                ];
            })->toArray(), // Use the custom accessor here
        ];
    }
}
