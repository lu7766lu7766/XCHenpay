<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2018/11/1
 * Time: 上午 11:21
 */

namespace App\Service;

use App\Contract\Information\INotify;
use App\Events\Information\Notify\LendRecordUpdated;
use App\Http\Requests\LendManageDataRequest;
use App\Http\Requests\LendManageDataTotalRequest;
use App\Http\Requests\LendManageTotalRequest;
use App\Http\Requests\LendManageUpdateRequest;
use App\Repositories\AuthCodes;
use App\Repositories\LendRecords;
use App\Traits\Singleton;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Validation\ValidationException;

class LendManageService
{
    use Singleton;
    const ALL_COMPANIES = -1;
    /**
     * @var array
     */
    protected $data;

    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * 下發管理申請列表資料
     * @return array
     */
    public function lendManageData()
    {
        $result = null;
        try {
            $handle = LendManageDataRequest::getHandle($this->data);
            $result = app(LendRecords::class)
                ->getLendRecords(
                    $handle->getStartDate(),
                    $handle->getEndDate(),
                    $handle->getUserId(),
                    $handle->getPage(),
                    $handle->getPerpage(),
                    $handle->getLendState(),
                    $handle->getKeyword(),
                    $handle->getSort(),
                    $handle->getDirection()
                );
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 下發管理申請列表資料總筆數
     * @return array
     */
    public function lendManageDataTotal()
    {
        $result = null;
        try {
            $handle = LendManageDataTotalRequest::getHandle($this->data);
            $result = app(LendRecords::class)
                ->getLendRecordsTotal(
                    $handle->getStartDate(),
                    $handle->getEndDate(),
                    $handle->getUserId(),
                    $handle->getLendState(),
                    $handle->getKeyword()
                );
            $result = ["total" => $result];
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 下發管理申請列表總金額,總手序費,申請中金额(totalApplying).可提現金額(totalWithdrawal)與小計(sum)
     * @return array
     */
    public function lendManageTotal()
    {
        $result = null;
        try {
            $handle = LendManageTotalRequest::getHandle($this->data);
            $sum = app(AuthCodes::class)->getTotalMoneyAndTotalFee($handle->getUserId());
            $totalRealMoney = round(app(AuthCodes::class)->getTotalRealMoney($handle->getUserId())->totalRealMoney, 3);
            $lendRecords = app(LendRecords::class)->getLendRecordTotalInfo($handle->getUserId());
            $totalLendRecords = round($lendRecords->totalLendRecords, 3);
            $result = [
                'total'           => round($sum->totalMoney, 3),
                'totalFee'        => round($sum->totalFee, 3),
                'totalApplying'   => round($lendRecords->totalApplying, 3),
                'totalAccepted'   => round($lendRecords->totalAccept, 3),
                'totalWithdrawal' => round($totalRealMoney - $totalLendRecords, 3)
            ];
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 更新下發列表申請單狀態
     * @return array
     */
    public function update()
    {
        $result = null;
        try {
            $handle = LendManageUpdateRequest::getHandle($this->data);
            $record = app(LendRecords::class)->find($handle->getId());
            /** @var User $user */
            $user = Sentinel::getUser();
            if ($handle->getOperation() == 1) {
                $record->update(
                    [
                        'lend_state'   => LendRecords::ACCEPT_STATE,
                        'lend_summary' => LendRecords::ACCEPT_SUMMARY,
                        'review_note'  => $handle->getNote(),
                    ]
                );
                activity($user->email)->causedBy($user)->log('准許一笔下发申请 ' . $record->record_seq);
            } else {
                $record->update(
                    [
                        'lend_state'   => LendRecords::DENY_STATE,
                        'lend_summary' => LendRecords::DENY_SUMMARY,
                        'review_note'  => $handle->getNote(),
                    ]
                );
                activity($user->email)->causedBy($user)->log('拒绝一笔下发申请 ' . $record->record_seq);
            }
            $result = [];
            event(INotify::class, new LendRecordUpdated($record));
        } catch (ValidationException $e) {
            $result = ["code" => 1000, "data" => $e->validator->getMessageBag()->getMessages()];
        } catch (\Throwable $e) {
            $result = ["code" => 1001, "data" => []];
        }

        return $result;
    }

    /**
     * 查詢狀態為下發中的訂單總數量
     * @return array
     */
    public function applyNotice()
    {
        $result = null;
        $notice = app(LendRecords::class)->getApplyLendRecordQuantity();
        if ($notice > -1) {
            $result = ['total' => $notice];
        } else {
            $result = [
                "code" => 1000,
                "data" => ['total' => $notice]
            ];
        }

        return $result;
    }
}
