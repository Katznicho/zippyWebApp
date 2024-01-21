<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'location',
        'room_type',
        'min_price',
        'max_price',

    ];
}
