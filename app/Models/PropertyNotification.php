<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyNotification extends Model
{
    use HasFactory;

    protected $table = 'zippy_property_notifications';

    protected $fillable = [
        'property_id',
        'user_id',
        'is_enabled',
        'match_percentage',
        'cost_percentage',
        'location_percentage',
        'services_percentage',
        'amenities_percentage',
        'rooms_percentage',
        'bathrooms_percentage',
        'notification_id',
        'score'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
