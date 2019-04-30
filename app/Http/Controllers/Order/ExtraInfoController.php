<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/18
 * Time: 下午 02:03
 */

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ExtraInfoRequest;
use App\Service\Order\ExtraInfoService;

class ExtraInfoController extends Controller
{
    /**
     * @param ExtraInfoRequest $request
     * @return array
     * @throws \App\Exceptions\ApiErrorScalarCodeException
     */
    public function add(ExtraInfoRequest $request)
    {
        return ['result' => ExtraInfoService::getInstance()->add($request)];
    }
}
