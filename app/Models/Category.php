<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image'

    ];


    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function getImageAttribute()
    {
        $imagePath = $this->attributes['image'];

        // Generate the full URL using the asset function
        return $imagePath ? asset("storage/{$imagePath}") : null;
    }
}
