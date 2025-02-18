<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
    ];
    public function details()
    {
        return $this->hasMany(OfferDetail::class);
    }
}
