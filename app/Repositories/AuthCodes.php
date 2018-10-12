<?php

namespace App\Repositories;

use App\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sentinel;
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

    public function companyData(User $user, $startDate, $endDate, $payState = null)
    {
        if (isset($payState)) {
            return $user->tradeLogs()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('pay_state', $payState)
                ->get($this->getCol);
        } else {
            return $user->tradeLogs()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get($this->getCol);
        }
    }

    public function makeSimpleDatatable($authCodes)
    {
        return DataTables::of($authCodes)
            ->addColumn('payment_name', function ($authCode) {
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
                $infoLink = '<a href=' . route('admin.authcode.showInfo',
                        ['authcode' => $authCode->id]) . ' data-toggle="modal" data-target="#show_Info"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title=' . trans('Trade/LogQuery/form.showModalTitle') . '></i></a>';
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
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getMoneyRecord(User $user)
    {
        $filterState = [
            $this::allDone_state,
            $this::accept_state,
            $this::deny_state
        ];
        $authCodes = $user->tradeLogs()
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
        $query = User::query()
            ->with([
                'tradeLogs'   => function (Relation $builder) {
                    $builder->select(
                        'company_service_id',
                        \DB::raw('SUM(amount) as totalMoney'),
                        \DB::raw('SUM(fee) as totalFee')
                    )->whereIn('pay_state', [self::allDone_state, self::accept_state, self::deny_state])
                        ->groupBy('company_service_id');
                },
                'LendRecords' => function (Relation $builder) {
                    $builder->select(
                        'user_id',
                        'lend_state',
                        \DB::raw('SUM(amount) as totalMoney')
                    )
                        ->whereIn('lend_state', [LendRecords::APPLY_STATE, LendRecords::ACCEPT_STATE])
                        ->groupBy('lend_state', 'user_id');
                }
            ]);
        if (!is_null($userId)) {
            $query->where('id', $userId);
        }
        $result = $query->get()->toArray();

        return $result;
    }
}
