<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'booking_id',
        'property_id',
        'amount',
        'currency',
    ];


    public function agent()
    {
        return $this->belongsTo(User::class);
    }
}
