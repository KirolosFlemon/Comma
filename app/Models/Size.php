<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'size',
    ];
    /**
     * Retrieves the variants associated with this size.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
