<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/26
 * Time: 上午 11:19
 */

namespace App\Service;

use AliPay\Service\AppTool;
use App\Http\Requests\BankCardGateway\GatewayRequest;
use App\Traits\Singleton;
use XC\Independent\Kit\Utils\URLUtil;

class StartUpService
{
    use Singleton;

    /**
     * @param GatewayRequest $request
     * @return string
     */
    public function taoBo(GatewayRequest $request)
    {
        $host = route('pay.gateway.view');
        $url = URLUtil::buildGet($host, ['trade_seq' => $request->getTradeSeq()]);
        $prefix = 'taobao://render.alipay.com/p/s/i?scheme=';
        $url = AppTool::openScanner($url);

        return $prefix . $url;
    }

    /**
     * @param GatewayRequest $request
     * @return string
     */
    public function aliPay(GatewayRequest $request)
    {
        $url = URLUtil::buildGet(route('pay.gateway.view'), [
            'trade_seq' => $request->getTradeSeq(),
            'wait'      => config('alipay.ali_pay_wait_sec'),
        ]);

        return AppTool::openScanner($url);
    }
}
