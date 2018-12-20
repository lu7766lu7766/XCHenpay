<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/14
 * Time: 上午 11:38
 */

namespace App\Factory;

use App\Constants\Common\SenderConstants;
use App\Helpers\JPushSMS;
use XC\Independent\Kit\Support\Traits\Pattern\Factory;

class SenderFactory
{
    use Factory;

    /**
     * @return array
     */
    public static function map(): array
    {
        return [
            SenderConstants::AURORA => JPushSMS::class,
        ];
    }
}
