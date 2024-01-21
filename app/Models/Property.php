<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status',
        'price',
        'zippy_id',
        'currency',
        'property_size',
        'year_built',
        'lat',
        'long',
        'location',
        'agent_id',
        'owner_id',
        'category_id'

    ];


    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, "amenity_property")
            ->withTimestamps();;
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'property_service')
            ->withTimestamps(); // If you want to include timestamps in the pivot table
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
}
