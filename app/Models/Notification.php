<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'user_id',
        'title',
        'body',
        'is_read',
        'property_id',
        'type',
        'message',
        
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
