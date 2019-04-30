<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/25
 * Time: 下午 03:50
 */

namespace App\Service\User;

use App\Http\Requests\UserPaymentAccount\AccountInfoRequest;
use App\Models\UserPaymentAccount;
use App\Repositories\UserPaymentAccountRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Support\Collection;

class UserPaymentAccountService
{
    use Singleton;
    /**@var User $user */
    private $user;

    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param AccountInfoRequest $request
     * @return \App\Models\UserPaymentAccount[]|Collection
     */
    public function info(AccountInfoRequest $request)
    {
        $result = app(UserPaymentAccountRepo::class)->getAccount(
            $this->user->getUserId(),
            $request->getVendors()
        );
        $result->each(function (UserPaymentAccount $account) {
            $account->setHidden([])
                ->setVisible(
                    [
                        'id',
                        'vendor',
                        'conn_config'
                    ]
                );
        });

        return $result;
    }
}
