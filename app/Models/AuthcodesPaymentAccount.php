<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/13
 * Time: 下午 01:11
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AuthcodesPaymentAccount extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'authcodes_payment_account';
}
