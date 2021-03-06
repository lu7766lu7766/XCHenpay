<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/21
 * Time: 下午 04:47
 */

namespace App\Service;

use App\Constants\ErrorCode\Article\OOO7BindBankCardErrorCodes;
use App\Constants\Roles\RolesConstants;
use App\Contract\Information\INotify;
use App\Events\Information\Notify\AccountStatusUpdate;
use App\Exceptions\ApiErrorScalarCodeException;
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
     * @throws ApiErrorScalarCodeException
     */
    public function delete(DeleteAccountRequest $handle)
    {
        $result = false;
        $bankCardRepo = app(BankCardRepo::class);
        $bankCard = $bankCardRepo->findNoLendRecordBankCard($handle->getId());
        if (is_null($bankCard)) {
            throw new ApiErrorScalarCodeException(
                "指定绑定的银行卡,尚还有存在着下发申请,故不能删除此卡片",
                OOO7BindBankCardErrorCodes::BIND_BANK_CARD_STILL_EXIST_LEND_APPLY_STATUS
            );
        }
        try {
            $result = $bankCardRepo->deleteOrm($bankCard);
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
        $bankCardRepo = app(BankCardRepo::class);
        $result = $bankCardRepo->update($request->getId(), $data);
        if ($result) {
            event(
                INotify::class,
                new AccountStatusUpdate($bankCardRepo->find($request->getId()))
            );
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

    /**
     * 處理中筆數
     * @return int
     */
    public function pendingCount()
    {
        return app(BankCardRepo::class)->pendingCount();
    }
}
