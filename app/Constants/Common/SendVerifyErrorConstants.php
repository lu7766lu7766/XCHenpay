<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/13
 * Time: 下午 06:00
 */

namespace App\Constants\Common;

class SendVerifyErrorConstants
{
    //此帐户未绑定联络电话
    const USER_NO_MOBILE = 10001;
    //验证码输入错误，请重新输入
    const VALIDATE_ERROR = 10002;
    //验证码逾时，请重新获取验证码
    const VALIDATE_EXPIRED = 10003;
    //此验证码已使用，请重新获取验证码
    const VALIDATE_INACTIVE = 10004;
}
