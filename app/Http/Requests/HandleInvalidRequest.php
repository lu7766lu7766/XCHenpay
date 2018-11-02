<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2018/7/4
 * Time: 下午 01:08
 */

namespace App\Http\Requests;

abstract class HandleInvalidRequest extends AbstractLaravelRequest
{
    /**
     * @param array $request
     * @return AbstractLaravelRequest|static
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function getHandle(array $request)
    {
        return $handle = parent::getHandle($request);
    }
}
