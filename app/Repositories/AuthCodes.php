<?php

namespace App\Repositories;

use App\Constants\Order\OrderStatusConstants;
use App\Constants\Roles\RolesConstants;
use App\Models\Authcode;
use App\Models\LendRecord;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Sentinel;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\DataTables;
use function trans;

class AuthCodes
{
    const APPLY_SUCCESS_STATE = 0; // 申請成功
    const TRADING_STATE = 1;  //交易中
    const SUCCESS_STATE = 2; //交易成功等待回調
    const ALL_DONE_STATE = 3; //交易結束
    const TRADE_FAIL_STATE = 4; //交易失敗
    const PENDING_STATE = 5;
    const ACCEPT_STATE = 6;
    const DENY_STATE = 7;
    private $getCol = [
        'id',
        'pay_state',
        'pay_summary',
        'trade_seq',
        'company_service_id',
        'trade_service_id',
        'amount',
        'currency_id',
        'payment_type',
        'fee',
        'created_at',
        'pay_start_time',
        'pay_end_time'
    ];

    /**
     * 商戶注單
     * @param int $company
     * @param string $startDate
     * @param string $endDate
     * @param int $page
     * @param int $perpage
     * @param int|null $payState
     * @param string|null $keyword 關鍵字
     * @param int|null $paymentType
     * @param string $sort 排序欄位
     * @param string $direction 排序規格
     * @return array array of the key => [orders , count].
     */
    public function companyDataWithReport(
        int $company,
        string $startDate,
        string $endDate,
        int $page = 1,
        int $perpage = 20,
        int $payState = null,
        string $keyword = null,
        int $paymentType = 0,
        string $sort = 'created_at',
        string $direction = 'desc'
    ) {
        $query = Authcode::query()->whereHas('company', function (Builder $builder) use ($company) {
            $builder->where('id', $company);
        });
        if (!is_null($payState)) {
            $query->where('pay_state', $payState);
        }
        if (!is_null($keyword)) {
            $query->where(function (Builder $b) use ($keyword) {
                $b->where('trade_seq', $keyword)
                    ->orWhere('trade_service_id', $keyword);
            });
        }
        if ($paymentType > 0) {
            $query->where('payment_type', $paymentType);
        }
        $query->whereBetween('created_at', [$startDate, $endDate]);
        $count = $query->count();
        $fee = $query->sum('fee');
        $amount = $query->sum('amount');
        $orders = $query->with(['i6payment', 'company', 'currency'])
            ->orderBy($sort, $direction)
            ->forPage($page, $perpage)
            ->get($this->getCol);

        return [$orders, $count, $fee, $amount];
    }

    public function makeSimpleDatatable($authCodes, $totalRecords)
    {
        /** @var CollectionDataTable $orm */
        $orm = DataTables::of($authCodes);
        $result = $orm->addColumn('payment_name', function ($authCode) {
            return $authCode->i6payment->name;
        })
            ->addColumn('currency_name', function ($authCode) {
                return $authCode->currency->name;
            })
            ->addColumn('company_name', function ($authCode) {
                return $authCode->company->company_name;
            })
            ->addColumn('actions', function ($authCode) {
                $callBackLink = '<a href="javascript: void(0);" data-callUrl="' . $authCode->id . '" class="notifyBtn"><i class="livicon" data-name="rocket" data-size="18" data-loop="true" data-c="#e9573f" data-hc="#e9573f" title=' . trans('Trade/LogQuery/form.callBackTitle') . '></i></a>';
                $infoLink = '<a href='
                    . route('admin.authcode.showInfo', ['authcode' => $authCode->id])
                    . ' data-toggle="modal" data-target="#show_Info">
                    <i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LogQuery/form.showModalTitle') . '></i></a>';
                $editLink = '<a href=' . route('admin.authcode.showState',
                        ['authcode' => $authCode->id]) . ' data-toggle="modal" data-target="#stateEditModal"><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="订单状态修改"></i></a>';
                $action = $infoLink;
                $user = Sentinel::getUser();
                if ($user->hasAccess('logQuery')) {
                    $action .= $editLink;
                }
                if ($authCode->pay_state == $this::SUCCESS_STATE) {
                    $action .= $callBackLink;
                }

                return $action;
            })
            ->setTotalRecords($totalRecords)
            ->rawColumns(['actions'])
            ->make(true);

        return $result;
    }

    /**
     * 申請中金额,可提現金額
     * @param int|null $userId
     * @return array
     */
    public function applyingAndWithdrawalAmount(int $userId = null)
    {
        $lendRecords = LendRecord::query()
            ->whereHas('user', function (Builder $builder) use ($userId) {
                if (!is_null($userId)) {
                    $builder->where('id', $userId);
                }
            })
            ->whereIn('lend_state', [LendRecords::APPLY_STATE, LendRecords::ACCEPT_STATE])
            ->select(
                \DB::raw('IFNULL(SUM(case when lend_state=0 then amount else 0 end),0) as totalApplying'),
                \DB::raw('IFNULL(SUM(amount),0) as totalLendRecords')
            )
            ->first();
        $tradeLogs = Authcode::query()
            ->whereHas('company', function (Builder $builder) use ($userId) {
                if (!is_null($userId)) {
                    $builder->where('id', $userId);
                }
            })
            ->whereIn('pay_state', [self::ALL_DONE_STATE, self::ACCEPT_STATE, self::DENY_STATE])
            ->select(\DB::raw('IFNULL(SUM(amount - fee),0) as totalRealMoney'))
            ->first();

        return [$lendRecords, $tradeLogs];
    }

    /**
     * 查詢報表資訊
     * @param string $startDate 開始時間
     * @param string $endDate 結束時間
     * @param string $companyServiceId
     * @return Collection
     */
    public function getReportRecord(string $startDate, string $endDate, string $companyServiceId = null)
    {
        try {
            $builder = User::with([
                'tradeLogs' => function ($builder) use ($startDate, $endDate, $companyServiceId) {
                    /** @var Builder $builder */
                    $builder->with('payment')->selectRaw(
                        "IFNULL(round(sum(amount),2),0) as amount,
                        IFNULL(round(sum(authcodes.fee),2),0) as fee,
                        IFNULL(count(1), 0) as count ,                        
                        company_service_id,
                        pay_state,
                        payment_type"
                    )
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->groupBy('company_service_id', 'payment_type', 'pay_state');
                }
            ])
                ->whereHas('roles', function (Builder $builder) {
                    $builder->where('roles.slug', RolesConstants::USER);
                })
                ->select(
                    'company_name',
                    'company_service_id'
                );
            if (!is_null($companyServiceId)) {
                $builder->where('company_service_id', $companyServiceId);
            }
            $result = $builder->get();
        } catch (\Throwable $e) {
            $result = new Collection();
        }

        return $result;
    }

    /**
     * 得到指定對象的總加合
     * @param array $companyServiceId
     * @return Authcode
     */
    public function getTotalMoneyAndTotalFee(array $companyServiceId)
    {
        return Authcode::query()
            ->select(\DB::raw('IFNULL(SUM(amount),0 )as totalMoney'), \DB::raw('IFNULL(SUM(fee),0) as totalFee'))
            ->whereIn('company_service_id', $companyServiceId)
            ->whereIn('pay_state', [
                OrderStatusConstants::ALL_DONE_CODE,
                OrderStatusConstants::ACCEPT_CODE,
                OrderStatusConstants::DENY_CODE
            ])->first();
    }
}
