<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable =
    ['user_id', 'device_id', 'device_model', 'device_manufacturer', 'app_version', 'device_os', 'device_os_version', 'device_user_agent', 'device_type', 'push_token'];

    //device belongs to user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
