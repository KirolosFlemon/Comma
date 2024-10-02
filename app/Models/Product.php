<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_ar',
        'name_en',
        'price',
        'price_after_discount',
        'sku',
        'brand_id',
        'best_seller',
        'description_ar',
        'description_en',
    ];
    /**
     * Get the value of the name attribute based on the current locale.
     *
     * @return string The value of the name attribute.
     */
    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    /**
     * Get the value of the description attribute based on the current locale.
     *
     * @return string The value of the description attribute.
     */
    public function getDescriptionAttribute()
    {
        return $this['description_' . app()->getLocale()];
    }


    /**
     * Retrieve the categories associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id');
    }

    /**
     * Retrieve the collections associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_products', 'product_id', 'collection_id');
    }

    /**
     * Retrieve the branches associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_products', 'product_id', 'branch_id');
    }
    /**
     * Retrieve the brand associated with the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Retrieve the variants associated with the current model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    /**
     * Retrieve the variants associated with the current model, with their color, material, and size.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variantsWithColorMaterialAndSize()
    {
        return $this->hasMany(Variant::class)
            ->with(['color', 'material', 'size']);
    }
    /**
     * Retrieves the product that owns this product image.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function details()
    {
        return $this->hasMany(OfferDetail::class);
    }
}
