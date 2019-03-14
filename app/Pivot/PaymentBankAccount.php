<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/29
 * Time: 下午 05:33
 */

namespace App\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class PaymentBankAccount
 * @package App\Pivot
 * @property array payment_detail
 */
class PaymentBankAccount extends Pivot
{
    protected $casts = ['payment_detail' => 'array'];
}
