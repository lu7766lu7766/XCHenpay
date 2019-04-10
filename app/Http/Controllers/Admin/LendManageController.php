<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepo;
use App\Service\LendManageService;
use App\User;
use Illuminate\View\View;

class LendManageController extends BaseController
{
    /**
     * @return view
     */
    public function index()
    {
        return view('admin.trade.lendManage');
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function dataInit()
    {
        return [
            'companies'  => app(UserRepo::class)->getCompanies()->map(function (\App\User $item) {
                return $item->setVisible(
                    ['id', 'company_name']
                );
            }),
            'lendStatus' => [
                '0' => '下发中',
                '1' => '完成下发',
                '2' => '拒绝下发'
            ]
        ];
    }

    /**
     * 下發管理申請列表資料
     * @return array
     */
    public function data()
    {
        $service = LendManageService::getInstance($this->getReq());

        return $service->lendManageData();
    }

    /**
     * 下發管理申請列表資料總數
     * @return array
     */
    public function dataTotal()
    {
        $service = LendManageService::getInstance($this->getReq());

        return $service->lendManageDataTotal();
    }

    /**
     * 下發管理申請列表小計與總計金額
     * @return array
     */
    public function total()
    {
        $service = LendManageService::getInstance($this->getReq());

        return $service->lendManageTotal();
    }

    /**
     * 更新下發列表申請單狀態
     * @return array
     */
    public function update()
    {
        $service = LendManageService::getInstance($this->getReq());

        return $service->update();
    }

    /**
     * 下發中的訂單總數量
     * @return array
     */
    public function applyNotice()
    {
        $service = LendManageService::getInstance($this->getReq());

        return $service->applyNotice();
    }
}
