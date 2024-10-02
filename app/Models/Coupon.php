<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'type',
        'value',
        'all_users',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_users', 'coupon_id', 'user_id');
    }
}
