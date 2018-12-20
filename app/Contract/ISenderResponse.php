<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/12/14
 * Time: 下午 02:57
 */

namespace App\Contract;

interface ISenderResponse
{
    /**
     * @return bool
     */
    public function isHttpSuccess();

    /**
     * @return bool
     */
    public function isSendSuccess();

    /**
     * @return int
     */
    public function getErrorCode();

    /**
     * @return string|null
     */
    public function getErrorMsg();

    /**
     * @return array
     */
    public function response();
}
