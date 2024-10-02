<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'user_id', 'address_id', 'status_id', 'coupon_price',
        'shipping_price', 'payment_type_id', 'payment_status',
        'transaction_id', 'coupon_id', 'total', 'grand_total', 'notes','delivered_at'
    ];
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(paymentType::class);
    }
}
