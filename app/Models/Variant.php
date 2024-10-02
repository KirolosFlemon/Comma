<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Variant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'material_id',
        'additional_price',
        'inventory_number',
        'out_of_stock',
        'image',
    ];


    /**
     * Retrieve the product associated with the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Retrieve the color associated with the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The color associated with the variant.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function sizes()
    {
        return $this->hasManyThrough(
            Size::class,          // The target model
            SizeVariant::class,  // The intermediary model
            'variant_id',         // Foreign key on the ColorVariant model
            'id',                 // Foreign key on the Color model
            'id',                 // Local key on the Variant model
            'size_id'            // Local key on the ColorVariant model
        );
    }

    /**
     * Retrieve the size associated with the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The size associated with the variant.
     */
    public function size()
    {
        return $this->sizes()->where('carts.size_variant_id','id');
    }
    /**
     * Retrieve the material associated with the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The material associated with the variant.
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Retrieve the images associated with the variant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany The images associated with the variant.
     */
    public function colorVariant()
    {
        return $this->hasMany(ColorVariant::class);
    }
    public function getImageAttribute($value)
    {
        return ($value) ? Storage::url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        // if (is_file($value)) {
            $this->attributes['image'] = $value ? Storage::disk('public')->put('uploads/Variant', $value) : $value;

            // $this->attributes['image'] =  $value->store('uploads/Brand');
        // }
    }
}
