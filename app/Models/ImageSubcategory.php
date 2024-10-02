<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImageSubcategory extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'image',
        'sub_category_id'
    ];
    public function category()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function getImageAttribute($value)
    {
        return ($value) ? Storage::url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = $value ? Storage::disk('public')->put('uploads/subcategory', $value) : $value;
        }
    }
}
