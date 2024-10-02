<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CategoryImage extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'image',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageAttribute($value)
    {
        $this->attributes['image'] = $value ? Storage::disk('public')->put('uploads/category', $value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] =  $value->store('uploads/Category');
        }
    }
}
