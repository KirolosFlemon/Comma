<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Color extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name_ar',
        'name_en',
        'image',
        
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
     * Get the value of the image attribute.
     *
     * @param datatype $value description
     * @return Some_Return_Value
     */
    public function getImageAttribute($value)
    {
        return ($value) ? Storage::url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = $value ? Storage::disk('public')->put('uploads/color', $value) : $value;
        }
    }
    
    /**
     * Retrieves the variants associated with this color.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    
}
