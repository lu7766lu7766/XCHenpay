<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int active
 * @property string created_at
 */
class verifyCode extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
