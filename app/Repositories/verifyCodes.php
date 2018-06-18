<?php

namespace App\Repositories;

use App\verifyCode;


class VerifyCodes
{
    const MIN = 0;
    const MAX = 999999;

    const ACTIVE_STAT = 1;
    const EXPIRED_STAT = 0;

    const ACTIVE_CODE = 'Active';
    const EXPIRED_CODE = 'Expired';

    public function generateCode()
    {
        return strval(rand($this::MIN, $this::MAX));
    }

    public function createActiveCode($randCode)
    {
        return verifyCode::create([
            'code' => $randCode,
            'status' => $this::ACTIVE_STAT,
            'stat_summary' => $this::ACTIVE_CODE
        ]);
    }

    public function verify($code)
    {

    }
}