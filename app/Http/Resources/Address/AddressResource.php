<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\City\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address' => $this->address, // Use the custom accessor here
            'lat' => $this->lat,
            'long' => $this->long,
            'room_floor' => $this->room_floor,
            'notes' => $this->notes,
            'phone' => $this->phone,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            // 'user' => $this->whenLoaded('user'),
            'city' => new CityResource($this->whenLoaded('city')),

        ];
    }
}
