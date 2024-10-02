<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name_ar',
        'name_en',
        'address',
        'lat',
        'long',
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
     * Retrieve the products associated with the branch.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'branch_products', 'branch_id', 'product_id');
    }
}
