<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Account extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function lendRecords()
    {
        return $this->hasMany(LendRecord::class, 'account_id', 'id');
    }
}
