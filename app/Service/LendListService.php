<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/20
 * Time: 下午 03:18
 */

namespace App\Service;

use App\Constants\Account\AccountStatusConstants;
use App\Constants\ErrorCode\Article\OOO3LendListErrorCodes;
use App\Constants\Lend\LendStatusConstants;
use App\Constants\User\UserStatusConstants;
use App\Exceptions\ApiErrorScalarCodeException;
use App\Http\Requests\LendList\LendListApplyRequest;
use App\Http\Requests\LendList\LendListIndexRequest;
use App\Http\Requests\LendListInfoRequest;
use App\Http\Requests\LendListTotalRequest;
use App\Models\LendRecord;
use App\Repositories\AuthCodes;
use App\Repositories\BankCardRepo;
use App\Repositories\LendRecords;
use App\Traits\Singleton;
use App\User;
use App\Validator\SecurityCodeValidator;
use Carbon\Carbon;
use Cartalyst\Sentinel\Users\UserInterface;

class LendListService
{
    use Singleton;
    /** @var User */
    private $user;

    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function amountInfo()
    {
        $repo = app(AuthCodes::class);
        $handlingFee = $repo->getHandlingChargeTotal($this->user->getKey());
        $paidAmount = $repo->getRealPaidTotal($this->user->getKey());
        $lendAmount = app(LendRecords::class)->getApplyingAndWithdrawalAmount([$this->user->getKey()]);
        $totalMoney = round($paidAmount->totalMoney, 3);
        $totalFee = round($handlingFee->totalFee, 3);
        $applying = round($lendAmount->totalApply, 3);
        $accepted = round($lendAmount->totalAccept, 3);
        $withdrawal = round($totalMoney - $totalFee - $applying - $accepted, 3);
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
        return app(LendRecords::class)->list(
            $request->getStartTime(),
            $request->getEndTime(),
            $request->getPage(),
            $request->getPerPage(),
            $request->getSort(),
            $request->getNumber(),
            $request->getStatus(),
            $this->user->getKey()
        )->toArray();
    }

    /**
     * @param LendListApplyRequest $request
     * @return LendRecord|null|array
     * @throws \Exception
     */
    public function apply(LendListApplyRequest $request)
    {
        $item = null;
        $validator = new SecurityCodeValidator($this->user, $request->getSecurityCode());
        if (!$validator->isSuccess()) {
            throw new ApiErrorScalarCodeException(
                '安全码错误',
                OOO3LendListErrorCodes::SECURITY_CODE_ERROR
            );
        }
        $accountId = $request->getTargetId();
        $bank = app(BankCardRepo::class)->findOwner(
            $accountId,
            $this->user->getKey(),
            AccountStatusConstants::APPROVAL
        );
        if (is_null($bank)) {
            throw new ApiErrorScalarCodeException('银行卡为空', OOO3LendListErrorCodes::BANK_CARD_IS_EMPTY);
        }
        $applyAmount = $request->getAmount();
        $enableWithdrawal = $this->amountInfo()['withdrawal'];
        $lendFee = $this->user->lend_fee * $applyAmount;
        $withdrawal = $lendFee + $applyAmount;
        if ($enableWithdrawal <= $withdrawal) {
            throw new ApiErrorScalarCodeException('可提领金额不足', OOO3LendListErrorCodes::ENABLE_WITHDRAWAL_NOT_ENOUGH);
        }
        if ($this->user->apply_status == UserStatusConstants::OFF) {
            throw new ApiErrorScalarCodeException(
                '请确认否有申请权限',
                OOO3LendListErrorCodes::PLEASE_CHECK_APPLY_PERMISSION
            );
        }
        \DB::beginTransaction();
        $item = app(LendRecords::class)->create(
            [
                'record_seq'   => Carbon::now('Asia/Taipei')->format('YmdHis'),
                'user_id'      => $this->user->getKey(),
                'account_id'   => $accountId,
                'amount'       => $withdrawal,
                'fee'          => $lendFee,
                'lend_state'   => LendStatusConstants::APPLY_CODE,
                'lend_summary' => LendStatusConstants::APPLY,
                'description'  => $request->getNote()
            ]
        );
        if (!is_null($item)) {
            activity($this->user->email)
                ->causedBy($this->user)
                ->log('提交一笔下发申请，单号：' . $item->record_seq);
            \DB::commit();
        } else {
            \DB::rollBack();
        }

        return $item;
    }

    /**
     * @param LendListTotalRequest $request
     * @return array
     */
    public function total(LendListTotalRequest $request)
    {
        $count = app(LendRecords::class)->getListTotal(
            $request->getStartTime(),
            $request->getEndTime(),
            $request->getNumber(),
            $request->getStatus(),
            $this->user->getKey()
        );

        return ['count' => $count];
    }

    /**
     * @param LendListInfoRequest $request
     * @return LendRecord|null
     */
    public function info(LendListInfoRequest $request)
    {
        return app(LendRecords::class)->fullInfo($request->getId(), $this->user->getkey());
    }

    /**
     * @param User|UserInterface $user
     * @return array
     */
    public function bankCardInfo()
    {
        $result = app(BankCardRepo::class)->getCardStatusByOwner(
            $this->user->getKey(),
            AccountStatusConstants::APPROVAL
        )->toArray();

        return $result;
    }
}
