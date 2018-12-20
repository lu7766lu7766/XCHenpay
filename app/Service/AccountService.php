<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2018/11/21
 * Time: 下午 04:47
 */

namespace App\Service;

use App\Exceptions\ApiErrorCodeException;
use App\Http\Requests\Account\AddAccountRequest;
use App\Http\Requests\Account\DeleteAccountRequest;
use App\Http\Requests\Account\GetAccountRequest;
use App\Repositories\AccountRepo;
use App\Traits\SendVerifyCodeTraits;
use App\Traits\Singleton;
use App\User;
use App\Validator\CodeValidator;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Database\Eloquent\Collection;

class AccountService
{
    use Singleton;
    use SendVerifyCodeTraits;
    const BANK_CARD_LIMIT = 20;

    /**
     * @return Collection|User[]
     */
    public function companyInfo()
    {
        return app(AccountRepo::class)->companyInfo();
    }

    /**
     * 行卡列表
     * @param array $request
     * @return \App\Models\Account[]|Collection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function accountData(array $request)
    {
        $handle = GetAccountRequest::getHandle($request);

        return app(AccountRepo::class)->accountData(
            $handle->getUserId(),
            $handle->getSort(),
            $handle->getPage(),
            $handle->getPerpage(),
            $handle->getSearch()
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

        return app(AccountRepo::class)->total(
            $handle->getUserId(),
            $handle->getSearch()
        );
    }

    /**
     * @param AddAccountRequest $handle
     * @return array
     * @throws \Throwable
     */
    public function addAccount(AddAccountRequest $handle)
    {
        /** @var User $user */
        $user = \Sentinel::getUser();
        $validator = new CodeValidator(app(AccountRepo::class)->findValidateCode($user, $handle->getValidateCode()));
        if (!$validator->success()) {
            throw new ApiErrorCodeException($validator->getErrMsg(), $validator->getErrCode());
        }
        if ($user->accounts->count() < self::BANK_CARD_LIMIT) {
            $result = app(AccountRepo::class)->addAccount(
                $user,
                $handle->getName(),
                $handle->getBankAccount(),
                $handle->getBankName(),
                $handle->getBankBranch()
            );
        } else {
            return ['result' => '此商户已绑订' . self::BANK_CARD_LIMIT . '组帐号，请删除就有帐号后重试'];
        }

        return ['result' => $result];
    }

    /**
     * 行卡刪除
     * @param DeleteAccountRequest $handle
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function delete(DeleteAccountRequest $handle)
    {
        $result = app(AccountRepo::class)->delete($handle->getBankAccountId());
        if (!is_null($result)) {
            activity($result->user->email)
                ->performedOn($result->user)
                ->causedBy($result->user)
                ->log('取消绑订了一笔帐户');
        }

        return $result;
    }

    /**
     * 綁定行卡刪除
     * @param DeleteAccountRequest $handle
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function deleteData(DeleteAccountRequest $handle)
    {
        $userId = \Sentinel::getUser()->getUserId();
        $result = app(AccountRepo::class)->delete($handle->getBankAccountId(), $userId);
        if (!is_null($result)) {
            activity($result->user->email)
                ->performedOn($result->user)
                ->causedBy($result->user)
                ->log('取消绑订了一笔帐户');
        }

        return $result;
    }

    /**
     * 綁定銀行卡列表
     * @param array $request
     * @return \App\Models\Account[]|Collection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function accountList(array $request)
    {
        $request['user_id'] = \Sentinel::getUser()->getUserId();
        $handle = GetAccountRequest::getHandle($request);

        return app(AccountRepo::class)->accountData(
            $handle->getUserId(),
            $handle->getSort(),
            $handle->getPage(),
            $handle->getPerpage(),
            $handle->getSearch()
        );
    }

    /**
     * 綁定銀行卡列表總數
     * @param array $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function listTotal(array $request)
    {
        $request['user_id'] = \Sentinel::getUser()->getUserId();
        $handle = GetAccountRequest::getHandle($request);

        return app(AccountRepo::class)->total(
            $handle->getUserId(),
            $handle->getSearch()
        );
    }

    /**
     * @return UserInterface|User
     */
    public function getReceiver()
    {
        return \Sentinel::getUser();
    }
}
