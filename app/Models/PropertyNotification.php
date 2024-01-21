<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyNotification extends Model
{
    use HasFactory;


    protected $fillable = [
        'property_id',
        'user_id',
        'is_enabled',
        'match_percentage',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
