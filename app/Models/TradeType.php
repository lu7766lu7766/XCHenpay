<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 */
class TradeType extends Model
{
    protected $table = 'trade_types';
    protected $fillable = [
        'name',
        'description'
    ];
    public $timestamps = false;

    public function tradeLogs()
    {
        return $this->hasMany(Authcode::class, 'trade_type', 'id');
    }
}
