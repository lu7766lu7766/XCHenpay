<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/14
 * Time: 下午 03:27
 */

namespace App\Service;

use App\Constants\Roles\RolesConstants;
use App\Http\Requests\CashierManage\AccountManageIndexRequest;
use App\Http\Requests\CashierManage\AccountManageInfoRequest;
use App\Http\Requests\CashierManage\AccountManageTotalRequest;
use App\Models\BankCardAccount;
use App\Repositories\BankCardAccountManageRepo;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Support\Collection;

class BankCardAccountManageService
{
    use Singleton;

    /**
     * @return User[]|Collection
     */
    public function merchant()
    {
        return app(UserRepo::class)->getRole(RolesConstants::USER);
    }

    /**
     * @param AccountManageIndexRequest $request
     * @return BankCardAccount[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(AccountManageIndexRequest $request)
    {
        return app(BankCardAccountManageRepo::class)->list(
            $request->getUserId(),
            $request->getStatus(),
            $request->getSearch(),
            $request->getPage(),
            $request->getPerpage()
        );
    }

    /**
     * @param AccountManageTotalRequest $request
     * @return int
     */
    public function total(AccountManageTotalRequest $request)
    {
        return app(BankCardAccountManageRepo::class)->total(
            $request->getUserId(),
            $request->getStatus(),
            $request->getSearch()
        );
    }

    /**
     * @param AccountManageInfoRequest $request
     * @return BankCardAccount|null
     */
    public function info(AccountManageInfoRequest $request)
    {
        return app(BankCardAccountManageRepo::class)->info($request->getId());
    }
}
