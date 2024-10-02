<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name_ar',
        'name_en',
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
     * Retrieve the images associated with the current instance of the Collection model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(CollectionImage::class);
    }

    /**
     * Retrieve the collections associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_products', 'collection_id', 'product_id');
    }
    public function details()
    {
        return $this->hasMany(OfferDetail::class);
    }
}
