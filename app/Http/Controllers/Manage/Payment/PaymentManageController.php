<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/11
 * Time: 下午 01:44
 */

namespace App\Http\Controllers\Manage\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\SystemSetting\PaymentManageAddRequest;
use App\Http\Requests\SystemSetting\PaymentManageDataListRequest;
use App\Http\Requests\SystemSetting\PaymentManageDataTotalRequest;
use App\Http\Requests\SystemSetting\PaymentManageDelRequest;
use App\Http\Requests\SystemSetting\PaymentManageDetailRequest;
use App\Http\Requests\SystemSetting\PaymentManageUpdateRequest;
use App\Service\PaymentManageService;

class PaymentManageController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function indexView()
    {
        return view('admin.system.paymentManage');
    }

    /**
     * @param PaymentManageDataListRequest $request
     * @return array
     */
    public function dataList(PaymentManageDataListRequest $request)
    {
        return ['data' => PaymentManageService::getInstance()->list($request)];
    }

    /**
     * @param PaymentManageDataTotalRequest $request
     * @return array
     */
    public function dataTotal(PaymentManageDataTotalRequest $request)
    {
        return ['data' => PaymentManageService::getInstance()->total($request)];
    }

    /**
     * @param PaymentManageDetailRequest $request
     * @return array
     */
    public function detail(PaymentManageDetailRequest $request)
    {
        return ['data' => PaymentManageService::getInstance()->detail($request)];
    }

    /**
     * @param PaymentManageAddRequest $request
     * @return array
     */
    public function add(PaymentManageAddRequest $request)
    {
        return ['data' => PaymentManageService::getInstance()->add($request)];
    }

    /**
     * @param PaymentManageUpdateRequest $request
     * @return array
     */
    public function update(PaymentManageUpdateRequest $request)
    {
        return ['data' => PaymentManageService::getInstance()->update($request)];
    }

    /**
     * @param PaymentManageDelRequest $request
     * @return array
     */
    public function del(PaymentManageDelRequest $request)
    {
        return ['data' => PaymentManageService::getInstance()->del($request)];
    }
}
