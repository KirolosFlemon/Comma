<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name ,
            // 'last_name' => $this->last_name ,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'token' => $this->token ,

            // 'image' => $this->image->isNotNull() ?$this->image : 'null' ,
        ];
    }
}
