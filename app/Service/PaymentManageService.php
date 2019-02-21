<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/11
 * Time: 下午 02:21
 */

namespace App\Service;

use App\Http\Requests\SystemSetting\PaymentManageAddRequest;
use App\Http\Requests\SystemSetting\PaymentManageDataListRequest;
use App\Http\Requests\SystemSetting\PaymentManageDataTotalRequest;
use App\Http\Requests\SystemSetting\PaymentManageDelRequest;
use App\Http\Requests\SystemSetting\PaymentManageDetailRequest;
use App\Http\Requests\SystemSetting\PaymentManageUpdateRequest;
use App\Models\UserPaymentAccount;
use App\Repositories\UserPaymentAccountRepo;
use App\Traits\Singleton;
use Illuminate\Support\Collection;

class PaymentManageService
{
    use Singleton;
    /**
     * @var UserPaymentAccountRepo
     */
    private $userPaymentAccountRepo;

    private function __construct()
    {
        $this->userPaymentAccountRepo = new UserPaymentAccountRepo();
    }

    /**
     * 金流帳號列表
     * @param PaymentManageDataListRequest $request
     * @return UserPaymentAccount[]|Collection
     */
    public function list(PaymentManageDataListRequest $request)
    {
        return $this->userPaymentAccountRepo->getList(
            $request->getStatus(),
            $request->getKeyword(),
            $request->getPage(),
            $request->getPerPage()
        );
    }

    /**
     * 金流帳號列表總筆數
     * @param PaymentManageDataTotalRequest $request
     * @return int
     */
    public function total(PaymentManageDataTotalRequest $request)
    {
        return $this->userPaymentAccountRepo->getTotal(
            $request->getStatus(),
            $request->getKeyword()
        );
    }

    /**
     * 金流帳號明細
     * @param PaymentManageDetailRequest $request
     * @return UserPaymentAccount|null
     */
    public function detail(PaymentManageDetailRequest $request)
    {
        return $this->userPaymentAccountRepo->getDetail($request->getId())
            ->makeVisible('conn_config');
    }

    /**
     * 新增金流帳號
     * @param PaymentManageAddRequest $request
     * @return UserPaymentAccount|null
     */
    public function add(PaymentManageAddRequest $request)
    {
        $result = null;
        $params = [
            "name"          => $request->getName(),
            "status"        => $request->getStatus(),
            "min_deposit"   => $request->getMinDeposit(),
            "max_deposit"   => $request->getMaxDeposit(),
            "total_deposit" => $request->getTotalDeposit(),
            "deposit_type"  => $request->getDepositType(),
            "withdraw"      => $request->getWithdraw(),
            "vendor"        => $request->getVendor(),
            "conn_config"   => $request->getConnConfig()
        ];
        $orm = app(UserPaymentAccount::class);
        if ($this->userPaymentAccountRepo->store(
            $orm,
            $params
        )) {
            $result = $orm->makeVisible('conn_config');
        }

        return $result;
    }

    /**
     * 更新金流帳號
     * @param PaymentManageUpdateRequest $request
     * @return UserPaymentAccount|null
     */
    public function update(PaymentManageUpdateRequest $request)
    {
        $result = null;
        $paymentAccount = $this->userPaymentAccountRepo->getDetail($request->getId());
        if (!is_null($paymentAccount)) {
            $params = [
                "name"          => $request->getName(),
                "status"        => $request->getStatus(),
                "min_deposit"   => $request->getMinDeposit(),
                "max_deposit"   => $request->getMaxDeposit(),
                "total_deposit" => $request->getTotalDeposit(),
                "deposit_type"  => $request->getDepositType(),
                "withdraw"      => $request->getWithdraw(),
                "vendor"        => $request->getVendor(),
                "conn_config"   => $request->getConnConfig()
            ];
            if ($this->userPaymentAccountRepo->store(
                $paymentAccount,
                $params
            )) {
                $result = $paymentAccount->makeVisible('conn_config');
            }
        }

        return $result;
    }

    /**
     * 刪除金流帳號
     * @param PaymentManageDelRequest $request
     * @return bool
     */
    public function del(PaymentManageDelRequest $request)
    {
        $result = false;
        $noOrder = $this->userPaymentAccountRepo->isNoOrder($request->getId());
        if ($noOrder) {
            $result = $this->userPaymentAccountRepo->del($request->getId());
        }

        return $result;
    }
}
