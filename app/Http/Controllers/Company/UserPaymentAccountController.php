<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/4/25
 * Time: 下午 03:22
 */

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPaymentAccount\AccountInfoRequest;
use App\Models\UserPaymentAccount;
use App\Service\Company\UserPaymentAccountService;
use Illuminate\Support\Collection;

class UserPaymentAccountController extends Controller
{
    /**
     * @param AccountInfoRequest $request
     * @return UserPaymentAccount[]|Collection
     */
    public function info(AccountInfoRequest $request)
    {
        return UserPaymentAccountService::getInstance()->info($request);
    }
}
