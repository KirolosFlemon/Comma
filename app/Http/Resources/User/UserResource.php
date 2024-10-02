<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name, // Use the custom accessor here
            // 'last_name' => $this->last_name, // Use the custom accessor here
            'username' => $this->username, // Use the custom accessor here
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image

        ];
    }
}
