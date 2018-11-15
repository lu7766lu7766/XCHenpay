<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class LendRecord extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
