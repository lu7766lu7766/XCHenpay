<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/15
 * Time: 上午 11:03
 */

namespace App\Service\User\Order;

use App\Http\Requests\Listener\BankCardOrderRequest;
use App\Http\Requests\Listener\IsCallBackRequest;
use App\Repositories\User\Order\ListenerRepo;
use App\Traits\Singleton;
use App\User;
use Carbon\Carbon;

class ListenerService
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
     * @param BankCardOrderRequest $request
     * @return \App\Models\Authcode|\Illuminate\Database\Eloquent\Collection
     */
    public function orderOfBankCard(BankCardOrderRequest $request)
    {
        $time = Carbon::now();
        $end = $time->toDateTimeString();
        $start = $time->subMinute(config('manageorderlistener.search_time'))->startOfMinute()->toDateTimeString();

        return app(ListenerRepo::class)->getOrderOfBankCard(
            $this->user->company_service_id,
            $request->getId(),
            $start,
            $end,
            $request->getPayState()
        );
    }

    /**
     * @param IsCallBackRequest $request
     * @return bool
     */
    public function isCallBack(IsCallBackRequest $request)
    {
        $time = new Carbon($request->getDate());
        $end = $time->toDateTimeString();
        $start = $time->subMinute(config('manageorderlistener.compare_time'))->startOfMinute()->toDateTimeString();
        $result = app(ListenerRepo::class)->getOrderByCardNoAmountDate(
            $this->user->company_service_id,
            $request->getCardNo(),
            $request->getAmount(),
            $start,
            $end
        )->isNotEmpty();

        return $result;
    }
}
