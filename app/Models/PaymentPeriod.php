<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPeriod extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //payment period belong to a property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
