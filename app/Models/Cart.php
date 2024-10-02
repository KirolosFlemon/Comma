<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'variant_id',
        'quantity',
        'size_variant_id',
    ];
    public function items() {
        return $this->hasMany(CartItem::class);
    }
    public function size() {
        return $this->belongsTo(SizeVariant::class,'size_variant_id','id');
    }
    
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    
    public function sizeVariant()
    {
        return $this->belongsTo(SizeVariant::class,'size_variant_id','id');
    }
    
    public function products()
    {
        return $this->belongsToThrough(Product::class, Variant::class);
    }
    
}
