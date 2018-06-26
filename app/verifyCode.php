<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Authcode;

class verifyCode extends Model
{
    protected $guarded = [];

    public function authCode()
    {
        return $this->hasMany(Authcode::class, 'verifyCode_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'verifyCode_id', 'id');
    }

    public function attachCode(Authcode $trade)
    {
        $this->authCode()->save($trade);
    }

    public function attachUser(User $user)
    {
        $this->users()->save($user);
    }
}
