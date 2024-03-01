<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZippyAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'services',
        'amenities',
        'minimum_price',
        'maximum_price',
        'contact_options',
        'number_of_bedrooms',
        'number_bathrooms',
        'is_active',
        'latitude',
        'longitude',
        'address'
    ];

    protected $cast = [
        'is_active' => 'boolean',
        'services' => 'array',
        'amenities' => 'array',
        'contact_options' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
