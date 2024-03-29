<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'images',
        'latitude',
        'longitude',
        'is_approved',
        'is_available',
        'cover_image',
        'number_of_beds',
        'number_of_baths',
        'number_of_rooms',
        'room_type',
        'furnishing_status',
        'status_id',
        'price',
        'zippy_id',
        'currency_id',
        'payment_period_id',
        'property_size',
        'year_built',
        'lat',
        'long',
        'location',
        'agent_id',
        'owner_id',
        'category_id',
        'owner_id',
        'public_facilities'

    ];


    protected $casts = [
        'images' => 'array',
        'public_facilities' => 'array'
    ];


    public function amenities()
    {
        return $this->belongsToMany(Amenity::class)
            ->using(AmenityProperty::class)
            ->withPivot('property_id', 'amenity_id');
    }

    //get only amenities ids
    public function getAmenitiesIdsAttribute()
    {
        return $this->amenities->pluck('id')->toArray();
    }

    public function amenityProperties(): HasMany
    {
        return $this->hasMany(AmenityProperty::class);
    }

    public function propertyServices(): HasMany
    {
        return $this->hasMany(PropertyService::class);
    }



    public function services()
    {
        return $this->belongsToMany(Service::class, 'property_service')
            ->withTimestamps(); // If you want to include timestamps in the pivot table
    }

    //get only services ids
    public function getServicesIdsAttribute()
    {
        return $this->services->pluck('id')->toArray();
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //belongs to agent
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    //belongs to owner
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    //property has a currency
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    //property has a status
    public function status()
    {
        return $this->belongsTo(PropertyStatus::class);
    }

    //property has payment period
    public function paymentPeriod()
    {
        return $this->belongsTo(PaymentPeriod::class);
    }

    public function getCoverImageAttribute()
    {
        $imagePath = $this->attributes['cover_image'];

        // Generate the full URL using the asset function
        return $imagePath ? asset("storage/properties/{$imagePath}") : null;
    }

    // Accessor for returning images as URLs
    // public function getImagesAttribute($value)
    // {
    //     $images = [];
    //     foreach ($value as $imagePath) {
    //         $images[] = $imagePath ? asset("storage/properties/{$imagePath}") : null;
    //     }
    //     return $images;
    // }
}
