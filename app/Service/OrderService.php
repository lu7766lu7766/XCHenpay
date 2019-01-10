<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/27
 * Time: 下午 04:47
 */

namespace App\Service;

use App\Http\Requests\AuthCodeOrderNotifyRequest;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;
use App\User;

class OrderService
{
    use Singleton;
    /** @var User $user */
    private $user;

    /**
     * @param User $user
     */
    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param AuthCodeOrderNotifyRequest $request
     * @return bool
     */
    public function callNotify(AuthCodeOrderNotifyRequest $request)
    {
        $result = false;
        $order = app(AuthCodes::class)->find($request->getId());
        if (!is_null($order) && $this->user->can('notify', ['OrderNotifyPolicy', $order])) {
            $result = app(OrderNotifyService::class)->notify($order);
        }

        return $result;
    }
}
