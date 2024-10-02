<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this);
        return [
            'id' => $this->id ,
            'name' => $this->first_name ,
            // 'last_name' => $this->last_name ,
            'username' => $this->username ,
            'email' => $this->email ,
            'phone' => $this->phone ,
            'image' => $this->image ,
            'token' => $this->token ,
      
        ];
    }
}
