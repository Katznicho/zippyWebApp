<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];



    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
