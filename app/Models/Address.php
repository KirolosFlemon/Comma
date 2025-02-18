<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable = [
        'address',
        'lat',
        'long',
        'user_id',
        'city_id',
        'room_floor',
        'notes',
        'phone',
    ];
    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
