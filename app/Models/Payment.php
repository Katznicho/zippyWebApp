<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'type',
        'amount', 
        'phone_number',
        'payment_mode',
        'payment_method',
        'description',
        'reference',
        'status',
        'property_id'
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
