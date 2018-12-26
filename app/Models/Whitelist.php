<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Whitelist
 * @package App\Models
 * @mixin Builder
 * @property array ip
 */
class Whitelist extends Model
{
    protected $table = 'white_list';
    protected $casts = ['ip' => 'json'];
    protected $fillable = [
        'user_id',
        'ip',
    ];
}
