<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CollectionImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'collection_id',
        'image',
    ];
    public function getImageAttribute($value)
    {
        return ($value) ? Storage::url($value) : $value;
    }

    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = $value ? Storage::disk('public')->put('uploads/collection', $value) : $value;
        }
    }
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
