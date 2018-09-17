<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeType extends Model
{
    protected $table = 'trade_types';

    public function tradeLogs(){
        return $this->hasMany(Authcode::class, 'trade_type', 'id');
    }
}
