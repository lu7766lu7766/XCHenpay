<?php

namespace App\Repositories;

use App\Authcode;
use App\verifyCode;


class VerifyCodes
{
    const MIN = 0;
    const MAX = 999999;

    const EXPIRED_STAT = 0;
    const ACTIVE_STAT = 1;
    const INACTIVE_STAT = 2;

//    const EXPIRED_SUMMARY = 'Expired';
//    const ACTIVE_SUMMARY = 'Active';
//    const INACTIVE_SUMMARY = 'Inactive';

    public function generateCode()
    {
        return strval(rand($this::MIN, $this::MAX));
    }

    public function createActiveCode($randCode)
    {
        return verifyCode::create([
            'code' => $randCode,
            'active' => $this::ACTIVE_STAT
        ]);
    }

    public function isActived(verifyCode $verifyCode, $code, $timestamp)
    {
        if($timestamp->diffInSeconds($verifyCode->created_at) >= 60 || $verifyCode->active == $this::EXPIRED_STAT){
            $verifyCode->update(['active' => $this::EXPIRED_STAT]);
            return $result = [
                'Result'=>'error',
                'Message'=> '验证码逾时，请重新获取验证码'
            ];
        }
        if($verifyCode->code != $code){
            return $result = [
                'Result'=>'error',
                'Message'=> '验证码输入错误，请重新输入',
            ];
        }elseif ($verifyCode->active == $this::INACTIVE_STAT){
            return $result = [
                'Result'=>'error',
                'Message'=> '此验证码已使用，请重新获取验证码'
            ];
        }else{
            if($verifyCode->authCode()->where('pay_state','<>',AuthCodes::lended_state)->count() == 1)
                $verifyCode->update(['active' => $this::INACTIVE_STAT]);

            return $result = [
                'Result'=>'OK'
            ];
        }

    }
}