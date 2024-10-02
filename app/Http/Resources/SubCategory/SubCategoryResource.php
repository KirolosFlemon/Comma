<?php

namespace App\Http\Resources\SubCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->{"name_" . app()->getLocale()}, // Use the custom accessor here
            // 'image' => $this->whenLoaded('images'),
            'category' => $this->category->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $this->{"name_" . app()->getLocale()}, // Use the custom accessor here
                    'slug' => $category->slug,
                ];
            }),
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
