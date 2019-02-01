<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/30
 * Time: 下午 03:38
 */

namespace App\Service;

use XC\Independent\Kit\Network\Curl\Curl;

class AliPayBankCardDetector extends AbstractBankCardDetector
{
    /**
     * @param string $cardNo
     * @return array
     * @throws \Exception
     */
    public function mining(string $cardNo): array
    {
        $curl = new Curl();
        $response = $curl->get('https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?cardNo=' .
            $cardNo . '&cardBinCheck=true');
        if ($response->isSuccess() && ($body = json_decode($response->body(), true)) && isset($body['bank'])) {
            $result = [
                'bank_mark' => $body['bank']
            ];
        } else {
            throw  new \Exception('獲取銀行卡簡稱失敗');
        }

        return $result;
    }
}
