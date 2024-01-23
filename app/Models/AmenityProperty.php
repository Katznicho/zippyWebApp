<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AmenityProperty extends Pivot
{
    use HasFactory;
    protected $table = 'amenity_property';
    protected $fillable = [
        'property_id',
        'amenity_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }
}
