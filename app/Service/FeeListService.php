<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/28
 * Time: 下午 04:49
 */

namespace App\Service;

use App\Http\Requests\FeeList\FeeListInfoRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Support\Collection;

class FeeListService
{
    use Singleton;
    /** @var User $user */
    private $user;

    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Payment[]|Collection
     */
    public function list()
    {
        $id = $this->user->getKey();

        return app(PaymentRepo::class)->list($id);
    }

    /**
     * @param FeeListInfoRequest $request
     * @return Payment|null
     */
    public function info(FeeListInfoRequest $request)
    {
        return app(PaymentRepo::class)->info($request->getId(), $this->user->getKey());
    }
}
