<?php

namespace App\Services\Order;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Order\OrderRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getGrandTotal(Request $request)
    {
        // $cartItems = Cart::where('user_id', auth()->id())->with(['variant.color', 'variant.sizes','variant.material','variant.product.brand'])->get();

        $cartItems = Cart::where('user_id', auth()->id())->with([
            'variant.color',
            /*
            'variant.sizes' => function ($query) {
                $query->whereIn('size_variants.id', function ($query) {
                    $query->select('size_variant_id')
                          ->from('carts')
                          ->whereColumn('carts.size_variant_id', 'size_variants.id');
                });
            },
            */
            'size.size',
            'variant.material',
            'variant.product.brand'
        ])->get();
        

        $totalCartItems = $cartItems->sum('quantity');

        $totalPrice = $this->calculateTotalPrice($cartItems);
        $couponPrice = $this->calculateCouponPrice($totalPrice, $request);
        $shipping = $this->calculateShipping($request);
        $offer_price = 0;
        if ($request->has('offer_id')) {
            $offerData = $this->calculateOfferPrice($request->offer_id, $totalPrice, $totalCartItems);
            $offer_price = $offerData['offer_price'];
            if ($offerData['shipping'] == 0) {
                $shipping = 0;
            }
        }


        return [
            'subtotal' => number_format($totalPrice, 2),
            'coupon_id' => $couponPrice['coupon_id'],
            'coupon_price' => number_format($couponPrice['coupon_price'], 2),
            'price_after_coupon' => number_format($couponPrice['price_after_coupon'], 2),
            'shipping' => $shipping,
            'offer_price' => $offer_price,
            'total' => number_format(($couponPrice['price_after_coupon'] + $shipping - $offer_price), 2),
            'items' => $cartItems,
        ];
    }
    public function calculateOfferPrice($offerId, $totalPrice, $quantity)
    {
        $offer = Offer::findOrFail($offerId);
        if (!$offer) {
            return 0; // Offer not found
        }

        switch ($offer->type) {
            case 'amount_off_product':
                // return  $offer_price = $this->calculateAmountOffProductOffer($offer, $totalPrice);
                return [
                    'offer_price' => $this->calculateAmountOffProductOffer($offer, $totalPrice)
                ];
            case 'buy_x_get_y':
                return [
                    'offer_price' => $this->calculateBuyXGetYOffer($offer, $totalPrice, $quantity)
                ];
            case 'free_shipping':
                return ['shipping' => 0, 'offer_price' => 0];
            default:
                return 0; // Unsupported offer type
        }
    }

    private function calculateAmountOffProductOffer($offer, $totalPrice)
    {
        $detail = $offer->details()->where('type', 'value')->first();

        if ($detail) {
            // If the detail type is 'value', it means the offer provides a fixed amount off
            return $offer_price = $detail->value;
        } else {
            // If the detail type is 'percentage', it means the offer provides a percentage off
            $percentageDetail = $offer->details()->where('type', 'percentage')->first();

            if ($percentageDetail) {
                $percentage = $percentageDetail->value / 100;
                return $offer_price = (($totalPrice * $percentage) / 100);
            } else {
                return $offer_price = 0; // No offer detail found
            }
        }
    }
    private function calculateBuyXGetYOffer($offer, $totalPrice, $quantity)
    {
        $detail = $offer->details()->where('type', 'value')->first();

        if ($detail) {
            // If the detail type is 'value', it means the offer provides a fixed amount off
            $offerQuantity = $detail->quantity;
            if ($quantity > $offerQuantity) {
                return $offer_price =  $detail->value;
            } else {
                return $offer_price = 0;
            }
        } else {
            // If the detail type is 'percentage', it means the offer provides a percentage off
            $percentageDetail = $offer->details()->where('type', 'percentage')->first();
            $offerQuantity = $percentageDetail->quantity;

            if ($percentageDetail && $offerQuantity > $quantity) {
                $percentage = $percentageDetail->value / 100;
                return  $offer_price = (($totalPrice * $percentage) / 100);
            } else {
                return $offer_price = 0; // No offer detail found
            }
        }
    }
    private function calculateShipping($request)
    {
        $shippingPrice = 0;
        $address = Address::where('user_id', auth()->id())->first();
        $shippingPrice = $address ? $address->city->shipping_price : 0;
        return $shippingPrice;
    }

    private function calculateTotalPrice($cartItems)
    {
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $price = $item->variant->product->price_after_discount ?? $item->variant->product->price;
            $totalPrice += $price * $item->quantity;
        }
        return $totalPrice;
    }

    private function calculateCouponPrice($totalPrice, $request)
    {
        $couponPrice = 0;
        $priceAfterCoupon = $totalPrice;

        if ($request->has('code')) {
            $coupon = Coupon::where('code', $request->code)->first();
            if ($coupon->all_users == 1 && in_array($coupon->type, ['value', 'percentage'])) {
                $couponPrice = $coupon->type == 'value' ? $coupon->value : ($totalPrice * $coupon->value) / 100;
                $priceAfterCoupon = $totalPrice - $couponPrice;
            }
        }

        return [
            'coupon_price' => $couponPrice,
            'price_after_coupon' => $priceAfterCoupon,
            'coupon_id' => $coupon->id ?? null,

        ];
    }

    public function getAllOrders(Request $request, $isPaginate)
    {
        return $this->orderRepository->all($request, $isPaginate);
    }

    public function createOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $address_id = null;
            $user = Auth()->user();
            if ($user) {

                if ($request->has('address_id')) {
                    $address_id = $request->address_id;
                } else {
                    if (!empty($user->addresses) && $user->addresses->isNotEmpty()) {
                        # code...
                        $address_id = $user->addresses[0]['id'];
                    } else {
                        $address = Address::create([
                            'address' => $request->address,
                            'city_id' => $request->city_id,
                            'user_id' => $user->id
                        ]);
                        $address_id = $address->id;
                    }
                }
            } else {

                $counter = 0;
                $email = $request->name . '@demo.com';
                $exist_email = User::where('email', $email)->first();
                while ($exist_email) {
                    $counter++;
                    $email = $request->name . $counter . '@demo.com';
                    $exist_email = User::where('email', $email)->first();
                }

                $user = User::create([
                    'name' =>  $request->name,
                    'username' =>  $request->name,
                    'phone' =>  $request->phone,
                    'email' => $request->phone ?? $email,
                    'password' => 12345678,
                ]);

                $address = Address::create([
                    'address' => $request->address,
                    'city_id' => $request->city_id,
                    'user_id' => $user->id
                ]);
                $address_id = $address->id;

                $cart = Cart::create([
                    'user_id' => $user->id,
                    'variant_id' => $request->variant_id,
                    'quantity' =>  $request->quantity,
                ]);

                // Generate token for the newly created user
                $user['token'] = auth('api')->login($user);
            }

            $grandTotal = $this->getGrandTotal($request);
            if (count($grandTotal['items']) == 0) {
                return false;
            }

            Order::where('user_id', $user->id)
                ->where('payment_status', 0)
                ->delete();

            $order = $this->orderRepository->create([
                'user_id' => $user->id,
                'code' => $this->generateOrderCode(),
                'order_quantity' => count($grandTotal['items']),
                'status_id' => 1,
                'total' => $grandTotal['subtotal'],
                'coupon_price' => $grandTotal['coupon_price'],
                'coupon_id' => $grandTotal['coupon_id'] ?? null,
                'grand_total' => $grandTotal['price_after_coupon'] + $grandTotal['shipping'],
                'address_id' => $address_id,
                'payment_status' => 0,
                'shipping_price' => $grandTotal['shipping'],
                'payment_type_id' => $request->payment_type_id,
                'notes' => $request->notes ?? null,
                'delivered_at' => $request->delivered_at ?? null,
            ]);
            $this->addOrderItems($grandTotal['items'], $order, $grandTotal);

            Cart::where('user_id', auth()->id())->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return [
            'order' => $order->load('address.city'),
            'user' => $user,
        ];
        // return $order->load('address.city');
    }

    private function addOrderItems($orderItems, $order, $grandTotal)
    {

        foreach ($orderItems as $item) {
            $order->cartItems()->create([
                'variant_id' => $item->variant_id,
                'item_price' => $item->variant->product->price_after_discount ?? $item->variant->product->price,
                'quantity' => $item->quantity,
                'total_price' => $order->total,
            ]);
        }
    }

    private function generateOrderCode(): string
    {
        $latestOrder = Order::orderBy('id', 'DESC')->first();
        $num = $latestOrder ? $latestOrder->id + 1 : 1;
        return 'ord-' . str_pad($num, 8, "0", STR_PAD_LEFT);
    }

    public function getOrderById($id)
    {
        return $this->orderRepository->find($id);
    }

    public function updateOrder($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderRepository->update($id, $request->except('images'));
            $order->images()->delete();

            if ($request->images) {
                foreach ($request->images as $image) {
                    $order->images()->create(['image' => $image]);
                }
            }
            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    public function deleteOrder($id)
    {
        $this->orderRepository->delete($id);
    }

    public function getSoftDeleted()
    {
        return $this->orderRepository->getSoftDeleted();
    }

    public function restore($id)
    {
        return $this->orderRepository->restore($id);
    }
}
