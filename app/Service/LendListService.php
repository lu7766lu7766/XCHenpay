<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/20
 * Time: 下午 03:18
 */

namespace App\Service;

use App\Constants\Lend\LendStatusConstants;
use App\Constants\User\UserStatusConstants;
use App\Http\Requests\LendList\LendListApplyRequest;
use App\Http\Requests\LendList\LendListIndexRequest;
use App\Http\Requests\LendListInfoRequest;
use App\Http\Requests\LendListTotalRequest;
use App\Models\LendRecord;
use App\Repositories\AuthCodes;
use App\Repositories\BankAccountRep;
use App\Repositories\LendRecords;
use App\Traits\Singleton;
use App\User;
use Carbon\Carbon;

class LendListService
{
    use Singleton;

    /**
     * @return array
     */
    public function amountInfo()
    {
        /** @var User|null $user */
        $user = \Sentinel::getUser();
        $totalMoney = 0;
        $totalFee = 0;
        $applying = 0;
        $withdrawal = 0;
        $accepted = 0;
        if (!is_null($user)) {
            $orderAmount = app(AuthCodes::class)->getTotalMoneyAndTotalFee([$user->company_service_id]);
            $lendAmount = app(LendRecords::class)->getApplyingAndWithdrawalAmount([$user->getKey()]);
            $withdrawal = round(
                round($totalMoney = $orderAmount->totalMoney, 3) -
                round($totalFee = $orderAmount->totalFee, 3) -
                round($applying = $lendAmount->totalApply, 3) -
                round($accepted = $lendAmount->totalAccept, 3),
                3
            );
        }
        $result = [
            'totalMoney' => $totalMoney,
            'totalFee'   => $totalFee,
            'applying'   => $applying,
            'withdrawal' => $withdrawal,
            'accepted'   => $accepted,
        ];

        return $result;
    }

    /**
     * @param LendListIndexRequest $request
     * @return array
     */
    public function index(LendListIndexRequest $request)
    {
        $result = [];
        /** @var User|null $user */
        $user = \Sentinel::getUser();
        if (!is_null($user)) {
            $result = app(LendRecords::class)->list(
                $request->getStartTime(),
                $request->getEndTime(),
                $request->getPage(),
                $request->getPerPage(),
                $request->getSort(),
                $request->getNumber(),
                $request->getStatus(),
                $user->getKey()
            )->toArray();
        }

        return $result;
    }

    /**
     * @param LendListApplyRequest $request
     * @return LendRecord|null
     * @throws \Exception
     */
    public function apply(LendListApplyRequest $request)
    {
        /** @var User|null $user */
        $item = null;
        $user = \Sentinel::getUser();
        if (!is_null($user)) {
            $accountId = $request->getTargetId();
            $bankAccounts = app(BankAccountRep::class)->findUser($user->getKey(), $accountId);
            $applyAmount = $request->getAmount();
            $enableWithdrawal = $this->amountInfo()['withdrawal'];
            $lendFee = $user->lend_fee * $applyAmount;
            $withdrawal = $lendFee + $applyAmount;
            if ($enableWithdrawal >= $withdrawal &&
                $bankAccounts->isNotEmpty() &&
                $user->apply_status == UserStatusConstants::ON
            ) {
                \DB::beginTransaction();
                $item = app(LendRecords::class)->create(
                    [
                        'record_seq'   => Carbon::now('Asia/Taipei')->format('YmdHis'),
                        'user_id'      => $user->getKey(),
                        'account_id'   => $accountId,
                        'amount'       => $withdrawal,
                        'fee'          => $lendFee,
                        'lend_state'   => LendStatusConstants::APPLY_CODE,
                        'lend_summary' => LendStatusConstants::APPLY,
                        'description'  => $request->getNote()
                    ]
                );
                if (!is_null($item)) {
                    activity($user->email)
                        ->causedBy($user)
                        ->log('提交一笔下发申请，单号：' . $item->record_seq);
                    \DB::commit();
                } else {
                    \DB::rollBack();
                }
            }
        }

        return $item;
    }

    /**
     * @param LendListTotalRequest $request
     * @return array
     */
    public function total(LendListTotalRequest $request)
    {
        $count = 0;
        /** @var User|null $user */
        $user = \Sentinel::getUser();
        if (!is_null($user)) {
            $count = app(LendRecords::class)->getListTotal(
                $request->getStartTime(),
                $request->getEndTime(),
                $request->getNumber(),
                $request->getStatus(),
                $user->getKey()
            );
        }

        return ['count' => $count];
    }

    /**
     * @param LendListInfoRequest $request
     * @return LendRecord|null
     */
    public function info(LendListInfoRequest $request)
    {
        /** @var User|null $user */
        $user = \Sentinel::getUser();
        $item = null;
        if (!is_null($user)) {
            $item = app(LendRecords::class)->fullInfo($request->getId(), $user->getkey());
        }

        return $item;
    }

    /**
     * @return array
     */
    public function backAccountInfo()
    {
        /** @var User|null $user */
        $result = [];
        $user = \Sentinel::getUser();
        if (!is_null($user)) {
            $result = app(BankAccountRep::class)->findUser($user->getKey())->toArray();
        }

        return $result;
    }
}
