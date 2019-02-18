<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/23
 * Time: 下午 04:33
 */

namespace App\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserInformationNotify extends Pivot
{
    protected $fillable = [
        'information_notify_id',
        'user_id',
        'deleted_at'
    ];
}
