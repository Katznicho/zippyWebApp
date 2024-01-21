<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'is_like',
        'is_dislike',
        'comment_id',
        'count',
        'rating',
    ];


    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
