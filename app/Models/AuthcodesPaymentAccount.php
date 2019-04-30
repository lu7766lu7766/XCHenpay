<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/13
 * Time: 下午 01:11
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class AuthcodesPaymentAccount
 * @package App\Models
 * @property int authcodes_id
 * @property int payment_account_id
 * @property string|null extra
 */
class AuthcodesPaymentAccount extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'authcodes_payment_account';
    /**
     * @var array
     */
    protected $casts = [
        'extra' => 'array'
    ];
}
