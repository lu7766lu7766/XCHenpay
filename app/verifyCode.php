<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Authcode;

class verifyCode extends Model
{
    protected $guarded = [];

//    public function authCode()
//    {
//        return $this->hasMany(Authcode::class, 'verifyCode_id', 'id');
//    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

//    public function attachCode(Authcode $trade)
//    {
//        $this->authCode()->save($trade);
//    }

}
