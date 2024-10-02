<?php

namespace App\Http\Resources\Color;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            'id' => $this->id,
            'name' => $this->{"name_" . app()->getLocale()}, // Use the custom accessor here
            'name_ar' => $this->name_ar, // Use the custom accessor here
            'name_en' => $this->name_en, // Use the custom accessor here
            'image' => $this->image,
        ];
    }
}
