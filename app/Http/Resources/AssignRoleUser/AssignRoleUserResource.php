<?php

namespace App\Http\Resources\AssignRoleUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignRoleUserResource extends JsonResource
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
            'role_name' => $this['name'], // Accessing 'name' from the array
            'users' => collect($this['users'])->map(function ($users) {
                return [
                    'id' => $users['id'],
                    'first_name' => $users['first_name'],
                    'last_name' => $users['last_name'],
                    'username' => $users['username'],
                    'email' => $users['email'],
                    'phone' => $users['phone'],
                ];
            })->toArray(), // Use the custom accessor here
        ];
    }
}
