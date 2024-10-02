<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['order']['id'],
            'code' => $this['order']['code'],
            'user_id' => $this['order']['user_id'],
            'address_id' => $this['order']['address_id'],
            'status_id' => $this['order']['status_id'],
            'coupon_price' => $this['order']['coupon_price'],
            'shipping_price' => $this['order']['shipping_price'],
            'payment_type_id' => $this['order']['payment_type_id'],
            'payment_status' => $this['order']['payment_status'],
            'transaction_id' => $this['order']['transaction_id'],
            'coupon_id' => $this['order']['coupon_id'],
            'total' => $this['order']['total'],
            'grand_total' => $this['order']['grand_total'],
            'notes' => $this['order']['notes'],
            'user' => new LoginResource($this['user']),
            'address' => new AddressResource($this['order']['address']),
            'status' => new StatusResource($this['order']['status']),

            // 'payment_type' => new PaymentTypeResource($this->paymentType),
        ];
    }
}
