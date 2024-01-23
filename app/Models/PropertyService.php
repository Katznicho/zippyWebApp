<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyService extends Pivot
{
    use HasFactory;


    protected $table = 'property_service';
    protected $fillable = [
        'property_id',
        'service_id',
    ];


    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
