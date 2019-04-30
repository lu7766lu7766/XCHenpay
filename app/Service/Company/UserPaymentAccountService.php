<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/25
 * Time: 下午 03:50
 */

namespace App\Service\Company;

use App\Http\Requests\UserPaymentAccount\AccountInfoRequest;
use App\Models\UserPaymentAccount;
use App\Repositories\UserPaymentAccountRepo;
use App\Traits\Singleton;
use Illuminate\Support\Collection;

class UserPaymentAccountService
{
    use Singleton;

    /**
     * @param AccountInfoRequest $request
     * @return UserPaymentAccount[]|Collection
     */
    public function info(AccountInfoRequest $request)
    {
        $result = app(UserPaymentAccountRepo::class)->getAccount(null, $request->getVendors());
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
