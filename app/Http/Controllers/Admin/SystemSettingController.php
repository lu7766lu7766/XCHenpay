<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/12/26
 * Time: 下午 04:27
 */

namespace App\Http\Controllers\Admin;

use App\Service\SystemSettingService;

class SystemSettingController extends BaseController
{
    /**
     * 帳號管理view
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        return view('admin.system.account');
    }

    /**
     * 帳號管理列表查詢
     * @return array
     */
    public function userList()
    {
        $service = SystemSettingService::getInstance($this->getReq());

        return $service->userList();
    }

    /**
     * 帳號管理列表總筆數查詢
     * @return array
     */
    public function userTotal()
    {
        $service = SystemSettingService::getInstance($this->getReq());

        return $service->userTotal();
    }

    /**
     * 查詢帳號資料明細
     * @return array
     */
    public function userDetail()
    {
        $service = SystemSettingService::getInstance($this->getReq());

        return $service->userDetail();
    }

    /**
     * 取得所有角色清單
     * @return array
     */
    public function getRolesList()
    {
        $service = SystemSettingService::getInstance($this->req);

        return $service->getRolesList();
    }

    /**
     * 新增帳號(非商戶)
     * @return array
     */
    public function userAdd()
    {
        $service = SystemSettingService::getInstance($this->getReq());

        return $service->userAdd();
    }

    /**
     * 更新帳號資訊(非商戶)
     * @return array
     */
    public function userUpdate()
    {
        $service = SystemSettingService::getInstance($this->getReq());

        return $service->userUpdate();
    }

    /**
     * 刪除帳號(非商戶)
     * @return array
     */
    public function userDel()
    {
        $service = SystemSettingService::getInstance($this->getReq());

        return $service->userDel();
    }
}
