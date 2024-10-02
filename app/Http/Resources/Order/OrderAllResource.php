<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderAllResource extends JsonResource
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
            'code' => $this->code,
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'status_id' => $this->status_id,
            'coupon_price' => $this->coupon_price,
            'shipping_price' => $this->shipping_price,
            'payment_type_id' => $this->payment_type_id,
            'payment_status' => $this->payment_status,
            'transaction_id' => $this->transaction_id,
            'coupon_id' => $this->coupon_id,
            'total' => $this->total,
            'grand_total' => $this->grand_total,
            'notes' => $this->notes,
            'user' => new LoginResource($this->user),
            'address' => new AddressResource($this->address),
            'status' => new StatusResource($this->status),

            // 'payment_type' => new PaymentTypeResource($this->paymentType),
        ];
    }
}
