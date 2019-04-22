<?php

namespace App\Repositories;

use App\Constants\Order\OrderStatusConstants;
use App\Constants\Roles\RolesConstants;
use App\Constants\User\UserStatusConstants;
use App\Models\Authcode;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AuthCodes
{
    const APPLY_SUCCESS_STATE = 0; // 申請成功
    const TRADING_STATE = 1;  //交易中
    const SUCCESS_STATE = 2; //交易成功等待回調
    const ALL_DONE_STATE = 3; //交易結束
    const TRADE_FAIL_STATE = 4; //交易失敗
    const AMOUNT_NOT_MATCH_STATE = 5;
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
        'pay_end_time',
        'real_paid_amount',
        'rand_fee'
    ];

    /**
     * 商戶注單
     * @param string $startDate
     * @param string $endDate
     * @param int|null $company
     * @param int $page
     * @param int $perpage
     * @param int|null $payState
     * @param string|null $keyword 關鍵字
     * @param int|null $paymentType
     * @param string $sort 排序欄位
     * @param string $direction 排序規格
     * @return Collection|Authcode[]
     */
    public function list(
        string $startDate,
        string $endDate,
        int $company = null,
        int $page = 1,
        int $perpage = 20,
        int $payState = null,
        string $keyword = null,
        int $paymentType = 0,
        string $sort = 'created_at',
        string $direction = 'desc'
    ) {
        $query = Authcode::query()->whereHas('company', function (Builder $builder) use ($company) {
            if (!is_null($company)) {
                $builder->where('id', $company);
            }
            $builder->whereHas('roles', function (Builder $builder) {
                $builder->where('slug', RolesConstants::USER);
            });
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
        $orders = $query->with([
            'i6payment',
            'company',
            'currency',
        ])->orderBy($sort, $direction)
            ->forPage($page, $perpage)
            ->get($this->getCol);

        return $orders;
    }

    /**
     * 商戶注單總數
     * @param string $startDate
     * @param string $endDate
     * @param int|null $company
     * @param int|null $payState
     * @param string|null $keyword 關鍵字
     * @param int|null $paymentType
     * @return int
     */
    public function companyDataWithReportTotal(
        string $startDate,
        string $endDate,
        int $company = null,
        int $payState = null,
        string $keyword = null,
        int $paymentType = 0
    ) {
        $query = Authcode::query()->whereHas('company', function (Builder $builder) use ($company) {
            if (!is_null($company)) {
                $builder->where('id', $company);
            }
            $builder->whereHas('roles', function (Builder $builder) {
                $builder->where('slug', RolesConstants::USER);
            });
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
        $result = $query->count();

        return $result;
    }

    /**
     * @param int|null $userId
     * @return Authcode
     */
    public function getTotalRealMoney(int $userId = null)
    {
        $result = Authcode::query()
            ->whereHas('company', function (Builder $builder) use ($userId) {
                if (!is_null($userId)) {
                    $builder->where('id', $userId);
                }
            })
            ->whereIn('pay_state', [self::ALL_DONE_STATE, self::ACCEPT_STATE, self::DENY_STATE])
            ->select(\DB::raw('IFNULL(SUM(amount - fee),0) as totalRealMoney'))
            ->first();

        return $result;
    }

    /**
     * 查詢報表資訊
     * @param string $startDate 開始時間
     * @param string $endDate 結束時間
     * @param string $companyServiceId
     * @return Collection|User[]
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
                        IFNULL(round(sum(real_paid_amount),2),0) as real_paid_amount,
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
     * @param int|null $userId
     * @return Authcode
     */
    public function getTotalMoneyAndTotalFee(int $userId = null)
    {
        return Authcode::query()
            ->select(
                \DB::raw('IFNULL(SUM(real_paid_amount),0 )as totalMoney'),
                \DB::raw('IFNULL(SUM(fee),0) as totalFee')
            )
            ->whereHas('company', function (Builder $builder) use ($userId) {
                $builder->whereHas('roles', function (Builder $b) {
                    $b->where('slug', RolesConstants::USER);
                });
                if (!is_null($userId)) {
                    $builder->where('id', $userId);
                }
            })->where('pay_state', OrderStatusConstants::ALL_DONE_CODE)->first();
    }

    /**
     * @param int $id
     * @return Authcode|null
     */
    public function find(int $id)
    {
        return Authcode::find($id);
    }

    /**
     * 使用user id尋找商戶
     * @param int $userId 商戶id
     * @return User
     */
    public function findMerchantByUserId(int $userId)
    {
        $result = User::query()
            ->where('status', UserStatusConstants::ON)
            ->where('id', $userId)
            ->whereHas('roles', function (Builder $builder) {
                $builder->where('slug', RolesConstants::USER);
            })->first();

        return $result;
    }

    /**
     * 取得當日交易資訊(交易成功金額,手續費,筆數)
     * @param string|null $companyServiceId
     * @return Authcode
     */
    public function getTradeInfoOnToday(string $companyServiceId = null)
    {
        try {
            $time = Carbon::today();
            $query = Authcode::query()
                ->select(
                    \DB::raw('IFNULL(round(SUM(real_paid_amount),2),0)as totalMoney'),
                    \DB::raw('IFNULL(round(SUM(fee),2),0) as totalFee'),
                    \DB::raw('count(*) as totalNum')
                )
                ->where('created_at', '>=', $time->startOfDay()->toDateTimeString())
                ->where('created_at', '<=', $time->endOfDay()->toDateTimeString())
                ->where('pay_state', OrderStatusConstants::ALL_DONE_CODE)
                ->whereHas('company', function (Builder $builder) {
                    $builder->whereHas('roles', function (Builder $b) {
                        $b->where('slug', RolesConstants::USER);
                    });
                });
            if (!is_null($companyServiceId)) {
                $query->where('company_service_id', $companyServiceId);
            }
            $result = $query->first();
        } catch (\Exception $e) {
            $result = null;
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * 訂單交易資訊
     * @param string $startDate
     * @param string $endDate
     * @param int|null $company
     * @param int|null $payState
     * @param int $paymentType
     * @return Authcode
     */
    public function orderTradeInfo(
        string $startDate,
        string $endDate,
        int $company = null,
        int $payState = null,
        int $paymentType = 0
    ) {
        $query = Authcode::query()
            ->select(
                \DB::raw('IFNULL(ROUND(SUM(fee),3),0)as fee'),
                \DB::raw('IFNULL(ROUND(SUM(IF(pay_state=' . self::ALL_DONE_STATE . ',real_paid_amount,0)),3),0)
                 as successful_deal'),
                \DB::raw('IFNULL(ROUND(SUM(IF(pay_state!=' . self::ALL_DONE_STATE . ',amount,0)),3),0) as failure_deal')
            )
            ->whereHas('company', function (Builder $builder) use ($company) {
                if (!is_null($company)) {
                    $builder->where('id', $company);
                }
                $builder->whereHas('roles', function (Builder $builder) {
                    $builder->where('slug', RolesConstants::USER);
                });
            })->whereBetween('created_at', [$startDate, $endDate]);
        if (!is_null($payState)) {
            $query->where('pay_state', $payState);
        }
        if ($paymentType > 0) {
            $query->where('payment_type', $paymentType);
        }
        $result = $query->first();

        return $result;
    }

    /**
     * @param string $tradeSeq
     * @return Authcode|null
     */
    public function getPayGateway(string $tradeSeq)
    {
        $result = null;
        try {
            $result = Authcode::query()
                ->with('bankCardAccount')
                ->where('trade_seq', $tradeSeq)
                ->where('created_at', '>=', Carbon::now()->subMinute(2)->toDateTimeString())
                ->first();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }

    /**
     * @param string $tradeSeq
     * @return Authcode|null
     */
    public function findPaymentWindow(string $tradeSeq)
    {
        $result = null;
        try {
            $result = Authcode::query()
                ->where('trade_seq', $tradeSeq)
                ->first();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }
}
