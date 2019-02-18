<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/26
 * Time: 下午 05:58
 */

namespace App\Service;

use App\Constants\Roles\RolesConstants;
use App\Http\Requests\FeeManagement\FeeManagementIndexRequest;
use App\Http\Requests\FeeManagement\FeeManagementInfoRequest;
use App\Http\Requests\FeeManagement\FeeManagementStoreRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepo;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Support\Collection;

class FeeManagementService
{
    use Singleton;

    /**
     * @param FeeManagementIndexRequest $request
     * @return Payment[]|Collection
     */
    public function list(FeeManagementIndexRequest $request)
    {
        return app(PaymentRepo::class)->list($request->getMerchantId());
    }

    /**
     * @return User[]|Collection
     */
    public function merchantList()
    {
        return app(UserRepo::class)->getRole(RolesConstants::USER);
    }

    /**
     * @param FeeManagementInfoRequest $request
     * @return Payment|null
     */
    public function info(FeeManagementInfoRequest $request)
    {
        return app(PaymentRepo::class)->info($request->getId(), $request->getMerchantId());
    }

    /**
     * @param FeeManagementStoreRequest $request
     * @return Payment|null
     */
    public function createOrUpdateByFee(FeeManagementStoreRequest $request)
    {
        $result = null;
        $user = app(UserRepo::class)->findRole(RolesConstants::USER, $request->getMerchantId());
        if (!is_null($user)) {
            $result = app(PaymentRepo::class)->createOrUpdateByFee(
                $request->getId(),
                $request->getMerchantId(),
                $request->getFee(),
                $request->getStatus()
            );
        }

        return $result;
    }
}
