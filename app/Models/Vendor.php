<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'logo',
        'banner',
        'address',
        'city',
        'postal_code',
        'phone',
        'business_license_number',
        'status',
        'rating',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function operatingHours()
    {
        return $this->hasMany(OperatingHour::class);
    }

    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
} 