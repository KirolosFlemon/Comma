<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'active',        
    ];
    
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
        // if (is_file($value)) {
            $this->attributes['image'] = $value ? Storage::disk('public')->put('uploads/Slider', $value) : $value;

            // $this->attributes['image'] =  $value->store('uploads/Brand');
        // }
    }
    
}
