<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'color_id',
        'variant_id',
    ];
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
