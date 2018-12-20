<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/14
 * Time: 下午 04:42
 */

namespace App\Traits;

use App\Bridge\SenderBridge;
use App\Constants\Common\SenderConstants;
use App\Constants\Common\SendVerifyErrorConstants;
use App\Exceptions\ApiErrorCodeException;
use App\Factory\SenderFactory;
use App\Repositories\VerifyCodes;
use App\User;

trait SendVerifyCodeTraits
{
    /**
     * @return User
     */
    abstract public function getReceiver();

    /**
     * @param int $type 驗證項目 參看app\Constants\Common\VerifyType
     * @return array
     * @throws ApiErrorCodeException
     */
    public function sendVerifyCode(int $type)
    {
        if (is_null($this->getReceiver())) {
            return ['result' => '此帐号不存在，请刷新页面后重试'];
        }
        if (!$mobile = $this->getReceiver()->mobile) {
            throw new ApiErrorCodeException('user no mobile', SendVerifyErrorConstants::USER_NO_MOBILE);
        }
        $validate = app(VerifyCodes::class);
        $code = $validate->generateCode();
        $sender = SenderFactory::make(SenderConstants::AURORA, [
            'key'    => env('JPUSH_KEY'),
            'secret' => env('JPUSH_SECRET')
        ]);
        $response = SenderBridge::getInstance($sender)->sendMessage($mobile, $code);
        if ($response->isHttpSuccess() && $response->isSendSuccess()) {
            $verifyCode = $validate->createActiveCode($code, $type);
            $this->getReceiver()->attachCode($verifyCode);
        }

        return $response->response();
    }
}
