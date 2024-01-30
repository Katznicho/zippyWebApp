<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'symbol', 'code', 'exchange_rate'];


    //a currency belong to a property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
