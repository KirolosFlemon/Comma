<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Branch\BranchResource;
use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Collection\CollectionResource;
use App\Http\Resources\Color\ColorResource;
use App\Http\Resources\Material\MaterialResource;
use App\Http\Resources\Size\SizeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description_ar' => $this->description_ar, // Use the custom accessor here
            'description_en' => $this->description_en, // Use the custom accessor here
            'description' => $this->{"description_" . app()->getLocale()}, // Use the custom accessor here
            'price' => $this->price,
            'price_after_discount' => $this->price_after_discount,
            'sku' => $this->sku,
            'best_seller' => $this->best_seller,
            'images' => $this->images,
            'brand' => new BrandResource($this->brand),
            'categories' => CategoryResource::collection($this->categories),
            'collections' => CollectionResource::collection($this->collections),
            'branches' => BranchResource::collection($this->branches),
            // 'size' =>  new SizeResource($this->sizes),

            'variants' => $this->variants->map(function ($variant) {

                return [
                    'id' => $variant->id,
                    'color' =>  new ColorResource($variant['color']),
                    'material' => new MaterialResource($variant['material']),
                    'size' =>  SizeResource::collection($variant['sizes']),
                    'inventory_number' => $variant->inventory_number,
                    'additional_price' => $variant->additional_price,
                    'out_of_stock' => $variant->out_of_stock,
                    'image' => $variant->image,
                ];
            })->toArray(),


        ];
    }
}
