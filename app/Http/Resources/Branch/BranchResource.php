<?php

namespace App\Http\Resources\Branch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'name_ar' => $this->name_ar, // Use the custom accessor here
            'name_en' => $this->name_en, // Use the custom accessor here
            'name' => $this->{"name_" . app()->getLocale()}, // Use the custom accessor here
            'lat' => $this->lat,
            'address' => $this->address,
            'long' => $this->long

        ];
    }
}
