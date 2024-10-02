<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'size_id',
        'variant_id',
    ];
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
