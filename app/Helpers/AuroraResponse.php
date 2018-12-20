<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/14
 * Time: 下午 02:38
 */

namespace App\Helpers;

use App\Contract\ISenderResponse;
use Curl\Curl;

class AuroraResponse implements ISenderResponse
{
    /**
     * @var Curl
     */
    private $httpResponse;

    /**
     * SenderResponse constructor.
     * @param Curl $httpResponse
     */
    public function __construct(Curl $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    /**
     * @return bool
     */
    public function isHttpSuccess()
    {
        return $this->httpResponse->getHttpStatusCode() != 0;
    }

    /**
     * @return int|null
     */
    public function getErrorCode()
    {
        return $this->httpResponse->response->error ?? null;
    }

    /**
     * @return bool
     */
    public function isSendSuccess()
    {
        return !isset($this->httpResponse->response->error);
    }

    /**
     * @return string|null
     */
    public function getErrorMsg()
    {
        return $this->httpResponse->response->error->message ?? null;
    }

    /**
     * @return array
     */
    public function response()
    {
        if ($this->isHttpSuccess() && $this->isSendSuccess()) {
            return ['result' => 'success'];
        } else {
            return [
                'result'  => 'error',
                'code'    => $this->getErrorCode(),
                'message' => $this->getErrorMsg()
            ];
        }
    }
}
