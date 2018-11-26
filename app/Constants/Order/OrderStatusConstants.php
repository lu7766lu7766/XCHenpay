<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/16
 * Time: 下午 03:50
 */

namespace App\Constants\Order;

class OrderStatusConstants
{
    const PREPARE_CODE = 0;
    const OPERATING_CODE = 1;
    const SUCCESS_CODE = 2;
    const ALL_DONE_CODE = 3;
    const FAILED_CODE = 4;
    const PENDING_CODE = 5;
    const ACCEPT_CODE = 6;
    const DENY_CODE = 7;
    const PREPARE = '申请成功';//交易申請成功
    const OPERATING = '交易中';//等待付费
    const SUCCESS = '交易成功,未回调';//成功接收金流通知，等待商户接收回调
    const ALL_DONE = '交易结束';//已可下发
    const FAILED = '交易失败';
    const DENY = '拒绝下发';
}
