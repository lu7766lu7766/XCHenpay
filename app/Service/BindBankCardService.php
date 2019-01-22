<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/17
 * Time: 下午 03:39
 */

namespace App\Service;

use App\Exceptions\ApiErrorCodeException;
use App\Http\Requests\BindBankCard\BindBankCardIndexRequest;
use App\Http\Requests\BindBankCard\BindBankCardInfoRequest;
use App\Http\Requests\BindBankCard\BindBankCardTotalRequest;
use App\Http\Requests\BindBankCardCreateRequest;
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
     * @param BindBankCardCreateRequest $handle
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
}
