<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/21
 * Time: 下午 04:47
 */

namespace App\Service;

use App\Constants\Roles\RolesConstants;
use App\Http\Requests\Account\AccountInfoRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Http\Requests\Account\DeleteAccountRequest;
use App\Http\Requests\Account\GetAccountRequest;
use App\Models\Account;
use App\Repositories\BankCardRepo;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class BankCardListService
{
    use Singleton;

    /**
     * @return Collection|User[]
     */
    public function companyInfo()
    {
        return app(UserRepo::class)->getRole(RolesConstants::USER);
    }

    /**
     * 行卡列表
     * @param array $request
     * @return Account[]|Collection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function accountData(array $request)
    {
        $handle = GetAccountRequest::getHandle($request);

        return app(BankCardRepo::class)->list(
            $handle->getSort(),
            $handle->getPage(),
            $handle->getPerpage(),
            $handle->getUserId(),
            $handle->getSearch(),
            $handle->getStatus()
        );
    }

    /**
     * 行卡列表總數
     * @param array $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function total(array $request)
    {
        $handle = GetAccountRequest::getHandle($request);

        return app(BankCardRepo::class)->total(
            $handle->getUserId(),
            $handle->getSearch(),
            $handle->getStatus()
        );
    }

    /**
     * @param DeleteAccountRequest $handle
     * @return bool
     */
    public function delete(DeleteAccountRequest $handle)
    {
        $result = false;
        try {
            $result = app(BankCardRepo::class)->delete($handle->getId());
            if ($result) {
                $activity = activity($result->user->email)
                    ->performedOn($result->user)
                    ->causedBy($result->user)
                    ->log('取消绑订了一笔帐户');
                if (is_null($activity)) {
                    throw  new \Exception("新增活動紀錄失敗");
                }
            }
        } catch (\Throwable $e) {
            \Log::error('file:' . $e->getFile() . 'line:' . $e->getLine() . 'message:' . $e->getMessage());
        }

        return $result;
    }

    /**
     * @param AccountUpdateRequest $request
     * @return array
     */
    public function update(AccountUpdateRequest $request)
    {
        $data = [
            'status' => $request->getStatus(),
            'note'   => $request->getNote()
        ];
        $result = app(BankCardRepo::class)->update($request->getId(), $data);
        if ($result) {
            /** @var User $user */
            $user = \Sentinel::getUser();
            activity($user->email)
                ->performedOn($user)
                ->causedBy($user)
                ->log("更新銀行卡ID:" . $request->getId() . " 狀態至 " . $request->getStatus());
        }

        return ['count' => $result];
    }

    /**
     * @param AccountInfoRequest $request
     * @return Account|null
     */
    public function info(AccountInfoRequest $request)
    {
        return app(BankCardRepo::class)->find($request->getId());
    }
}
