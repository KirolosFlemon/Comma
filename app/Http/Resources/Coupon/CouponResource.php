<?php

namespace App\Http\Resources\Coupon;

use App\Http\Resources\City\CityResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'code' => $this->code, // Use the custom accessor here
            'type' => $this->type,
            'value' => $this->value,
            'all_users' => $this->all_users,
            'users' => UserResource::collection($this->whenLoaded('users')),
            // 'user' => $this->whenLoaded('user'),

        ];
    }
}
