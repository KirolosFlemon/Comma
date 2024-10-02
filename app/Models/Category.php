<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name_ar', 'name_en', 'slug'];

    /**
     * Get the value of the "name" attribute, based on the current locale.
     *
     * @return string The value of the "name" attribute for the current locale.
     */
    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    /**
     * Retrieves the subcategories associated with this category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany The subcategories relationship.
     */
    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'category_sub_categories', 'category_id', 'sub_category_id');
    }
    /**
     * Retrieve the images associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(CategoryImage::class);
    }
    /**
     * Retrieve the products associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products', 'category_id', 'product_id');
    }
}
