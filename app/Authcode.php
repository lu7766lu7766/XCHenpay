<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\verifyCode;

class Authcode extends Model
{
    protected $guarded = [];

    public function verifyCode()
    {
        return $this->hasOne(verifyCode::class, 'id', 'verifyCode_id');
    }


}
