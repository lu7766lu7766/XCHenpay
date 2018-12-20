<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/13
 * Time: 下午 07:48
 */

namespace App\Bridge;

use App\Contract\ISenderService;
use App\Helpers\AuroraResponse;
use App\Traits\Singleton;

class SenderBridge
{
    use Singleton;
    /**
     * @var ISenderService
     */
    private $sender;

    /**
     * @param ISenderService $sender
     */
    public function init(ISenderService $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param ISenderService $sender
     */
    public function setSender(ISenderService $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param string $mobile
     * @param string $message
     * @return AuroraResponse
     */
    public function sendMessage(string $mobile, string $message)
    {
        $response = $this->sender->sendMessage($mobile, $message);

        return $response;
    }
}
