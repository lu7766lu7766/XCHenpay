<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/29
 * Time: 下午 05:33
 */

namespace App\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PaymentBankAccount extends Pivot
{
    protected $casts = ['payment_detail' => 'array'];
}
