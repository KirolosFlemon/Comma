<?php

namespace App\Http\Resources\City;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'postal_code' => $this->postal_code,
            'name' => $this->{"name_" . app()->getLocale()}, // Use the custom accessor here
            'name_ar' => $this->name_ar, // Use the custom accessor here
            'name_en' => $this->name_en, // Use the custom accessor here
            'shipping_price' => $this->shipping_price, // Use the custom accessor here
        ];
    }
}
