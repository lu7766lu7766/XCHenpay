<?php

namespace App\Repositories;


class AuthCodes
{
    const lended_state = 4;
    const accept_state = 5;
    const deny_state = 6;

    const lended_summary = '申请下发中';
    const accept_summary = '下发完成';
    const deny_summary = '拒绝下发';
}