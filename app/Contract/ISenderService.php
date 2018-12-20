<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/14
 * Time: 下午 01:58
 */

namespace App\Contract;

use App\Helpers\AuroraResponse;

interface ISenderService
{
    /**
     * @param string $mobile
     * @param string $message
     * @return AuroraResponse
     */
    public function sendMessage(string $mobile, string $message);
}
