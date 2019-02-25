<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/17
 * Time: 下午 03:39
 */

namespace App\Service;

use App\Constants\ErrorCode\Article\OOO7BindBankCardErrorCodes;
use App\Exceptions\ApiErrorCodeException;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\BindBankCard\BindBankCardCreateRequest;
use App\Http\Requests\BindBankCard\BindBankCardDeleteRequest;
use App\Http\Requests\BindBankCard\BindBankCardIndexRequest;
use App\Http\Requests\BindBankCard\BindBankCardInfoRequest;
use App\Http\Requests\BindBankCard\BindBankCardTotalRequest;
use App\Models\Account;
use App\Repositories\BankCardRepo;
use App\Repositories\UserRepo;
use App\Traits\SendVerifyCodeTraits;
use App\Traits\Singleton;
use App\User;
use App\Validator\CodeValidator;
use Illuminate\Database\Eloquent\Collection;

class BindBankCardService
{
    use Singleton, SendVerifyCodeTraits;
    /** @var User $user */
    private $user;

    /**
     * @param User $user
     */
    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param BindBankCardIndexRequest $request
     * @return Account[]|Collection
     */
    public function list(BindBankCardIndexRequest $request)
    {
        return app(BankCardRepo::class)->bindList(
            $request->getSort(),
            $request->getPage(),
            $request->getPerpage(),
            $this->user->getUserId(),
            $request->getSearch(),
            $request->getStatus()
        );
    }

    /**
     * @param BindBankCardTotalRequest $request
     * @return int
     */
    public function total(BindBankCardTotalRequest $request)
    {
        return app(BankCardRepo::class)->total(
            $this->user->getUserId(),
            $request->getSearch(),
            $request->getStatus()
        );
    }

    /**
     * @param BindBankCardInfoRequest $request
     * @return User|null
     */
    public function info(BindBankCardInfoRequest $request)
    {
        return app(BankCardRepo::class)->findOwner($request->getId(), $this->user->getUserId());
    }

    /**
     * @param \App\Http\Requests\BindBankCard\BindBankCardCreateRequest $handle
     * @return bool
     * @throws ApiErrorCodeException
     * @throws \Throwable
     */
    public function create(BindBankCardCreateRequest $handle)
    {
        $validator = new CodeValidator(
            app(UserRepo::class)->findValidateCode(
                $this->user,
                $handle->getValidateCode()
            )
        );
        if (!$validator->success()) {
            throw new ApiErrorCodeException($validator->getErrMsg(), $validator->getErrCode());
        }
        $result = app(BankCardRepo::class)->create(
            $this->user,
            $handle->getName(),
            $handle->getBankAccount(),
            $handle->getBankName(),
            $handle->getBankBranch()
        );
        if ($result) {
            activity($this->user->email)->causedBy($this->user)->log('绑订了一笔帐号');
        }

        return $result;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
        return $this->user;
    }

    /**
     * @param BindBankCardDeleteRequest $request
     * @return bool
     * @throws ApiErrorScalarCodeException
     */
    public function delete(BindBankCardDeleteRequest $request)
    {
        $bankCardRepo = app(BankCardRepo::class);
        $bankCard = $bankCardRepo->findNotLendingStatus($request->getId(), $this->user->getKey());
        if (is_null($bankCard)) {
            throw new ApiErrorScalarCodeException(
                "指定绑定的银行卡,尚还有存在着下发申请,故不能删除此卡片",
                OOO7BindBankCardErrorCodes::BIND_BANK_CARD_STILL_EXIST_LEND_APPLY_STATUS
            );
        }
        $result = $bankCardRepo->deleteOrm($bankCard);

        return $result;
    }
}
