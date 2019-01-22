<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/26
 * Time: 下午 02:15
 */

namespace App\Validator;

use App\Constants\Common\SendVerifyErrorConstants;
use App\Exceptions\ApiErrorCodeException;
use App\Models\verifyCode;
use App\Repositories\VerifyCodes;
use Carbon\Carbon;

class CodeValidator
{
    /** @var bool */
    private $success = true;
    /** @var string $errorMsg */
    private $errorMsg = '';
    /** @var int|null $errorCode */
    private $errorCode = null;
    /** @var verifyCode|null $item */
    private $item;

    /**
     * CodeValidator constructor.
     * @param verifyCode|null $code
     * @throws ApiErrorCodeException
     */
    public function __construct(verifyCode $code = null)
    {
        $this->setValidator($code);
    }

    /**
     * @param verifyCode|null $code
     * @throws ApiErrorCodeException
     */
    public function setValidator(verifyCode $code = null)
    {
        $this->item = $code;
        $this->check();
    }

    /**
     * @return string
     */
    public function getErrMsg()
    {
        return $this->errorMsg;
    }

    /**
     * @return int|null
     */
    public function getErrCode()
    {
        return $this->errorCode;
    }

    /**
     * @return bool
     */
    public function success()
    {
        return $this->success;
    }

    private function check()
    {
        if (is_null($this->item)) {
            $this->success = false;
            $this->errorMsg = '验证码输入错误，请重新输入';
            $this->errorCode = SendVerifyErrorConstants::VALIDATE_ERROR;
        } elseif (Carbon::now()->diffInSeconds($this->item->created_at) >= 60 ||
            $this->item->active == VerifyCodes::EXPIRED_STAT) {
            $this->item->update(['active' => VerifyCodes::EXPIRED_STAT]);
            $this->success = false;
            $this->errorMsg = '验证码逾时，请重新获取验证码';
            $this->errorCode = SendVerifyErrorConstants::VALIDATE_EXPIRED;
        } elseif ($this->item->active == VerifyCodes::INACTIVE_STAT) {
            $this->success = false;
            $this->errorMsg = '此验证码已使用，请重新获取验证码';
            $this->errorCode = SendVerifyErrorConstants::VALIDATE_INACTIVE;
        } else {
            $this->item->update(['active' => VerifyCodes::INACTIVE_STAT]);
        }
    }
}
