<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'product_id',
    ];

    /**
     * Retrieves the product that owns this product image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getImageAttribute($value)
    {
        return ($value) ? Storage::url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = $value ? Storage::disk('public')->put('uploads/Product', $value) : $value;
        }
    }

}
