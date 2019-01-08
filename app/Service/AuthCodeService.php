<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/24
 * Time: 下午 04:31
 */

namespace App\Service;

use App\Http\Requests\AuthCodeOrderSearchRequest;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;
use App\User;

class AuthCodeService
{
    use Singleton;
    /** @var User $user */
    private $user;

    /**
     * @param User $user
     */
    protected function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * 取得當日交易資訊(交易成功金額,手續費,筆數)
     * @return array
     */
    public function tradeInfoOnToday()
    {
        $companyServiceId = null;
        $merchant = app(AuthCodes::class)->findMerchantByUserId($this->user->id);
        if (!is_null($merchant)) {
            $companyServiceId = $merchant->company_service_id;
        }
        $tradeInfo = app(AuthCodes::class)->getTradeInfoOnToday($companyServiceId);

        return [
            'totalMoney' => $tradeInfo->totalMoney,
            'totalFee'   => $tradeInfo->totalFee,
            'totalNum'   => $tradeInfo->totalNum,
            'ip'         => \Request::getClientIp()
        ];
    }

    /**
     * 訂單交易資訊
     * @param AuthCodeOrderSearchRequest $request
     * @return \App\Models\Authcode
     */
    public function orderTradeInfo(AuthCodeOrderSearchRequest $request)
    {
        $company = $this->user->getKey();
        // 如果有擁有可選擇商戶的權限
        if ($this->user->hasAccess('users.dataSwitch')) {
            $company = $request->get('company');
        }

        return app(AuthCodes::class)->orderTradeInfo(
            $request->get('start'),
            $request->get('end'),
            $company,
            $request->get('pay_state'),
            $request->get('payment_type', 0)
        );
    }

    /**
     * @param AuthCodeOrderSearchRequest $request
     * @return int
     */
    public function total(AuthCodeOrderSearchRequest $request)
    {
        $company = $this->user->getKey();
        // 如果有擁有可選擇商戶的權限
        if ($this->user->hasAccess('users.dataSwitch')) {
            $company = $request->get('company');
        }

        return app(AuthCodes::class)->companyDataWithReportTotal(
            $request->get('start'),
            $request->get('end'),
            $company,
            $request->get('pay_state'),
            $request->get('keyword'),
            $request->get('payment_type', 0)
        );
    }
}
