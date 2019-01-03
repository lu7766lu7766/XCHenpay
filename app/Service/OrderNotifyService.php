<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/27
 * Time: 下午 04:00
 */

namespace App\Service;

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
        $response = $this->curl->get($this->url . '/' . $authcode->getKey());
        if ($response->isSuccess()) {
            if ($response->body() == OrderNotifyStatus::SUCCESS) {
                $result = true;
            }
        };

        return $result;
    }
}
