<?php

namespace App\Http\Resources\OfferDetail;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);     $details = [];
        foreach ($this['details'] as $detail) {
            $details[] = [
                'id' => $detail['id'],
                'code' => $detail['code'],
                'type' => $detail['type'],
                'value' => $detail['value'],
                'min_quantity' => $detail['min_quantity'],
                'detailable_type' => $detail['detailable_type'],
                'detailable_id' => $detail['detailable_id'],
            ];
        }
        return [
            'id' => $this['id'],
            'name' => $this['type'],
            'details' => $details,
        ];
    }
}
