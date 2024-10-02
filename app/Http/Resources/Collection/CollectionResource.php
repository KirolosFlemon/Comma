<?php

namespace App\Http\Resources\Collection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
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
            'name' => $this->{"name_" . app()->getLocale()}, // Use the custom accessor here
            'name_en' => $this->name_en, // Use the custom accessor here
            'name_ar' => $this->name_ar, // Use the custom accessor here
            // 'image' => $this->whenLoaded('images'),
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image' => $image->image, // Assuming the image attribute contains the URL
                    ];
                });
            }),
        ];
    }
}
