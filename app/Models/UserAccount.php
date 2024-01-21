<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'account_name',
        'account_currency',
        'account_balance',
        'show_wallet_balance',
        'pin',
        'is_active',
    ];

    //accont belongs to user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 
