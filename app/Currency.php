<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';

    public function authcodes(){
        return $this->hasMany(Authcode::class);
    }
}
