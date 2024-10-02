<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SubCategory extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable =
    [
        'name_ar',
        'name_en',
        'slug',
    ];
    public function getNameAttribute()
    {
        return $this['name_' . app()->getLocale()];
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_sub_categories', 'sub_category_id', 'category_id');
    }
    public function images()
    {
        return $this->hasMany(ImageSubcategory::class);
    }
}
