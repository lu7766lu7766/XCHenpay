<?php

namespace App\Repositories;

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
    const success_state = 2;
    const allDone_state = 3;
    const pending_state = 5;
    const accept_state = 6;
    const deny_state = 7;
    const lended_summary = '申请下发中';
    const accept_summary = '下发完成';
    const deny_summary = '拒绝下发';
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
                if ($authCode->pay_state == $this::success_state) {
                    $action .= $callBackLink;
                }

                return $action;
            })
            ->setTotalRecords($totalRecords)
            ->rawColumns(['actions'])
            ->make(true);

        return $result;
    }

    public function getMoneyRecord(User $user)
    {
        $filterState = [
            $this::allDone_state,
            $this::accept_state,
            $this::deny_state
        ];
        $authCodes = $user->tradeLogs()
            ->select([
                \DB::raw('sum(amount) as amount'),
                \DB::raw('sum(fee) as fee')
            ])
            ->whereIn('pay_state', $filterState)
            ->get();
        if (!$authCodes) {
            return $data['Result'] = 'error';
        }
        $lendRecords = $user->lendRecords;
        $totalLending = 0;
        $totalLended = 0;
        $totalMoney = 0;
        $totalFee = 0;
        $lendKeys = $lendRecords->groupBy('lend_state');
        $pendingRecords = $lendKeys->get(0);
        if ($pendingRecords) {
            $totalLending = $pendingRecords->sum('amount');
        }
        $acceptRecords = $lendKeys->get(1);
        if ($acceptRecords) {
            $totalLended = $acceptRecords->sum('amount');
        }
        foreach ($authCodes as $authCode) {
            $totalMoney += $authCode->amount;
            $totalFee += $authCode->fee;
        }
        $data = [
            'totalMoney'   => number_format($totalMoney, 3, ".", ","),
            'totalFee'     => number_format($totalFee, 3, ".", ","),
            'totalLending' => number_format($totalLending, 3, ".", ","),
            'totalLended'  => number_format($totalLended, 3, ".", ","),
            'totalIncome'  => number_format($totalMoney - $totalFee - $totalLending - $totalLended, 3, ".", ","),
        ];

        return $data;
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
            ->whereIn('pay_state', [self::allDone_state, self::accept_state, self::deny_state])
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
                    $builder->selectRaw(
                        "round(sum(case when pay_state = ? then amount else 0 end),2) success_amount,
                        round(sum(case when pay_state = ? then fee else 0 end),2) success_fee,
                        sum(case when pay_state = ? then 1 else 0 end) success_count,
                        round(sum(case when pay_state != ? then amount else 0 end),2) fail_amount,
                        round(sum(case when pay_state != ? then fee else 0 end),2) fail_fee,
                        sum(case when pay_state != ? then 1 else 0 end) fail_count,
                        company_service_id",
                        array_fill(0, 6, self::allDone_state)
                    )->whereBetween('created_at', [$startDate, $endDate])
                        ->groupBy('company_service_id');
                }
            ])->leftJoin('role_users', 'users.id', 'role_users.user_id')
                ->where('role_users.role_id', 4);
            if (!is_null($companyServiceId)) {
                $builder->where('company_service_id', $companyServiceId);
            }
            $result = $builder->get();
        } catch (\Throwable $e) {
            $result = new Collection();
        }

        return $result;
    }
}
