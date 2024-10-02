<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferDetail extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type', 'value','min_quantity','min_price'];

    public function detailable()
    {
        return $this->morphTo();
    }
    
    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}
