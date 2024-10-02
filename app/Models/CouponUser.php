<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'coupon_id',
        'user_id',
        'no_used_times',
    ];
}
