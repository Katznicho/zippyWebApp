<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'check_in_date',
        'check_out_date',
        'is_approved',
        'total_price',
        'duration_in_days',
        'payment_id',
    ];


    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //booking has a payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
