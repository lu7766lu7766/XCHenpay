<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/2
 * Time: 上午 11:38
 */

namespace App\Service;

use App\Models\Payment;
use App\Repositories\PaymentRepo;
use App\Traits\Singleton;
use Illuminate\Support\Collection;

class PaymentService
{
    use Singleton;

    /**
     * @return Payment[]|Collection
     */
    public function all()
    {
        return app(PaymentRepo::class)->allActive();
    }
}
