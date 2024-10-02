<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
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
     * Get the variants for the material.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
