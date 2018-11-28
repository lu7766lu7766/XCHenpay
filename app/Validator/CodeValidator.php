<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/26
 * Time: 下午 02:15
 */

namespace App\Validator;

use App\Constants\Account\AccountErrorConstants;
use App\Exceptions\ApiErrorCodeException;
use App\Repositories\VerifyCodes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CodeValidator
{
    private $success = true;
    private $errorMsg = '';
    private $item;

    /**
     * @return string
     */
    public function getErrMsg()
    {
        return $this->errorMsg;
    }

    /**
     * @param Model|null $code
     * @return bool
     * @throws ApiErrorCodeException
     */
    public function success(Model $code = null)
    {
        $this->item = $code;
        $this->check();

        return $this->success;
    }

    /**
     * @throws ApiErrorCodeException
     */
    private function check()
    {
        if (is_null($this->item)) {
            throw new ApiErrorCodeException('validate error', AccountErrorConstants::VALIDATE_ERROR);
        } elseif (Carbon::now()->diffInSeconds($this->item->created_at) >= 60 ||
            $this->item->active == VerifyCodes::EXPIRED_STAT) {
            $this->item->update(['active' => VerifyCodes::EXPIRED_STAT]);
            $this->success = false;
            $this->errorMsg = '验证码逾时，请重新获取验证码';
        } elseif ($this->item->active == VerifyCodes::INACTIVE_STAT) {
            $this->success = false;
            $this->errorMsg = '此验证码已使用，请重新获取验证码';
        } else {
            $this->item->update(['active' => VerifyCodes::INACTIVE_STAT]);
        }
    }
}
