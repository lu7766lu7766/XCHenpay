<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/27
 * Time: 下午 04:00
 */

namespace App\Service;

use App\Constants\Order\OrderStatusConstants;
use App\Constants\OrderNotify\OrderNotifyStatus;
use App\Models\Authcode;
use XC\Independent\Kit\Network\Curl\Curl;

class OrderNotifyService
{
    private $curl;
    private $url;

    /**
     * OrderNotify constructor.
     * @param Curl $curl
     */
    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
        $this->url = env('THIRD_PARTY_PAY_API_URL');
    }

    /**
     * @param Authcode $authcode
     * @return bool
     */
    public function notify(Authcode $authcode)
    {
        $result = false;
        if (($authcode->pay_state == OrderStatusConstants::SUCCESS_CODE) ||
            ($authcode->pay_state == OrderStatusConstants::ALL_DONE_CODE)) {
            $response = $this->curl->get($this->url . '/' . $authcode->getKey());
            if ($response->isSuccess()) {
                $result = $response->body() == OrderNotifyStatus::SUCCESS;
            };
        }

        return $result;
    }
}
