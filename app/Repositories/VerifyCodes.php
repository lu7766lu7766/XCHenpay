<?php

namespace App\Repositories;

use App\Models\verifyCode;
use Carbon\Carbon;

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

    /**
     * @param string $randCode
     * @param int $type
     * @return verifyCode
     */
    public function createActiveCode(string $randCode, int $type)
    {
        return verifyCode::create([
            'code'   => $randCode,
            'active' => $this::ACTIVE_STAT,
            'type'   => $type
        ]);
    }

    public function codeValidate(verifyCode $verifyCode, $timestamp)
    {
        if (is_null($verifyCode)) {
            return $result = ['Result' => 'error', 'Message' => '验证码输入错误，请重新输入或重新获取验证码'];
        }
        /** @var Carbon $timestamp */
        if ($timestamp->diffInSeconds($verifyCode->created_at) >= 60 || $verifyCode->active == $this::EXPIRED_STAT) {
            $verifyCode->update(['active' => $this::EXPIRED_STAT]);

            return $result = ['Result' => 'error', 'Message' => '验证码逾时，请重新获取验证码'];
        }
        $verifyCode->update(['active' => $this::INACTIVE_STAT]);

        return $result = ['Result' => 'OK'];
    }
}
