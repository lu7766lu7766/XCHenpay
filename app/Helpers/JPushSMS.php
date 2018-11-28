<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/22
 * Time: 下午 05:55
 */

namespace App\Helpers;

use Curl\Curl;

class JPushSMS
{
    //極光SMS
    private $key;
    private $secret;
    private $tempId = '1';

    public function __construct(string $key, string $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @param string $mobile
     * @param string $message
     * @return array
     * @throws \ErrorException
     */
    public function sendSMS(string $mobile, string $message)
    {
        $data = [
            'mobile'    => $mobile,
            'temp_id'   => $this->tempId,
            "temp_para" => ["code" => $message]
        ];
        $sendCode = new Curl();
        $sendCode->setBasicAuthentication($this->key, $this->secret);
        $sendCode->setHeader('Content-Type', 'application/json');
        $sendCode->post('https://api.sms.jpush.cn/v1/messages', json_encode($data));
        $response = $sendCode->response;
        if ($response) {
            if (!isset($response->error)) {
                return ['result' => 'success'];
            } else {
                return ['result' => 'error', 'message' => $response->error->message, 'code' => $response->error->code];
            }
        }

        return $response;
    }
}
