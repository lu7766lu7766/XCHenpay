<?php

namespace App\Repositories;

use App\Constants\Common\VerifyType;
use App\Models\LendRecord;
use App\Models\verifyCode;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;

class LendRecords
{
    const FEE = 0.0002;
    const APPLY_STATE = 0;
    const ACCEPT_STATE = 1;
    const DENY_STATE = 2;
    const APPLY_SUMMARY = '下发中';
    const ACCEPT_SUMMARY = '完成下发';
    const DENY_SUMMARY = '拒绝下发';

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @param int $page
     * @param int $perpage
     * @param int|null $lendState
     * @param string|null $keyword
     * @param string $sort
     * @param string $direction
     * @return mixed
     */
    public function getLendRecords(
        string $startDate,
        string $endDate,
        int $userId = null,
        int $page = 1,
        int $perpage = 10,
        int $lendState = null,
        string $keyword = null,
        string $sort = 'created_at',
        string $direction = 'desc'
    ) {
        $builder = $this->builderLendRecordQuery($startDate, $endDate, $userId, $lendState, $keyword);

        return $builder->orderBy($sort, $direction)
            ->forPage($page, $perpage)
            ->get([
                'id',
                'record_seq',
                'amount',
                'fee',
                'lend_summary',
                'user_id',
                'account_id',
                'created_at',
                'lend_state',
                'description'
            ]);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @param int|null $lendState
     * @param string|null $keyword
     * @return int
     */
    public function getLendRecordsTotal(
        string $startDate,
        string $endDate,
        int $userId = null,
        int $lendState = null,
        string $keyword = null
    ) {
        return $this->builderLendRecordQuery($startDate, $endDate, $userId, $lendState, $keyword)
            ->count();
    }

    /**
     * 取得下發列表資訊
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     * @param int $page
     * @param int $perpage
     * @param int|null $lendState
     * @param string|null $keyword
     * @param string $sort
     * @param string $direction
     * @return mixed
     */
    public function getUserRecords(
        int $userId,
        string $startDate,
        string $endDate,
        int $page = 1,
        int $perpage = 10,
        int $lendState = null,
        string $keyword = null,
        string $sort = 'created_at',
        string $direction = 'desc'
    ) {
        $builder = $this->builderLendRecordQuery($startDate, $endDate, $userId, $lendState, $keyword);

        return $builder->orderBy($sort, $direction)
            ->forPage($page, $perpage)
            ->get([
                'id',
                'record_seq',
                'amount',
                'fee',
                'lend_summary',
                'user_id',
                'account_id',
                'created_at',
                'lend_state',
                'description'
            ]);
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string|null $userId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getTotal(
        string $startDate,
        string $endDate,
        string $userId = null
    ) {
        $query = LendRecord::query()->whereBetween('created_at', [$startDate, $endDate]);
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }
        $query->select(\DB::raw('sum(amount-fee) as total'));
        $result = $query->first();

        return $result;
    }

    /**
     * @param array $userId
     * @return LendRecord
     */
    public function getApplyingAndWithdrawalAmount(array $userId)
    {
        return LendRecord::query()->select(
            \DB::raw(
                'IFNULL(SUM(CASE WHEN lend_state="' . LendRecords::APPLY_STATE .
                ' " THEN amount ELSE 0 END),0 )AS totalApply'
            ),
            \DB::raw(
                'IFNULL(SUM(CASE WHEN lend_state="' . LendRecords::ACCEPT_STATE .
                ' " THEN amount ELSE 0 END),0) AS totalAccept'
            )
        )->whereIn('user_id', $userId)->first();
    }

    /**
     * @param string $startTime
     * @param string $endTime
     * @param int $page
     * @param int $perpage
     * @param string $soft
     * @param string|null $number
     * @param int|null $status
     * @param int|null $userId
     * @return Collection|LendRecord[]
     * @see SortConstant $soft type
     */
    public function list(
        string $startTime,
        string $endTime,
        int $page,
        int $perpage,
        string $soft,
        string $number = null,
        int $status = null,
        int $userId = null
    ) {
        $query = LendRecord::query()->whereBetween('created_at', [$startTime, $endTime]);
        if (!is_null($status)) {
            $query->where('lend_state', $status);
        }
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }
        if (!is_null($number)) {
            $query->where(function (Builder $query) use ($number) {
                $query->where('record_seq', 'like', '%' . $number . '%');
                $query->orWhereHas('account', function (Builder $query) use ($number) {
                    $query->where('account', 'like', '%' . $number . '%');
                });
            });
        }
        $query->with([
            'account' => function (HasOne $query) {
                $query->withTrashed();
            }
        ])->orderBy('created_at', $soft);

        return $query->forPage($page, $perpage)->get();
    }

    /**
     * @param array $data
     * @return LendRecord|\Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $data)
    {
        $item = null;
        try {
            $item = LendRecord::query()->create($data);
        } catch (\Throwable $e) {
        }

        return $item;
    }

    /**
     * @param string $startTime
     * @param string $endTime
     * @param string|null $number
     * @param int|null $status
     * @param int|null $userId
     * @return int
     */
    public function getListTotal(
        string $startTime,
        string $endTime,
        string $number = null,
        int $status = null,
        int $userId = null
    ) {
        $query = LendRecord::query()->whereBetween('created_at', [$startTime, $endTime]);
        if (!is_null($status)) {
            $query->where('lend_state', $status);
        }
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }
        if (!is_null($number)) {
            $query->where(function (Builder $query) use ($number) {
                $query->where('record_seq', 'like', '%' . $number . '%');
                $query->orWhereHas('account', function (Builder $query) use ($number) {
                    $query->where('account', 'like', '%' . $number . '%');
                });
            });
        }

        return $query->count();
    }

    /**
     * @param int $id
     * @param int|null $userId
     * @return LendRecord|null
     */
    public function fullInfo(int $id, int $userId)
    {
        $query = LendRecord::query()->with([
            'account' => function (HasOne $query) {
                $query->withTrashed();
            }
        ])->where('id', $id)->where('user_id', $userId);

        return $query->first();
    }

    /**
     * 計算申請狀態為下發中的表單總數量
     * @return int
     */
    public function getApplyLendRecordQuantity()
    {
        $result = -1;
        try {
            $result = LendRecord::with(
                [
                    'account' => function (Relation $builder) {
                        $builder->withTrashed();
                    },
                    'user'
                ]
            )
                ->where('lend_records.lend_state', 0)
                ->count();
        } catch (\Throwable $e) {
        }

        return $result;
    }

    /**
     * 查詢指定id的lendRecord資訊
     * @param int $id
     * @return LendRecord|null
     */
    public function getLendRecordById(
        int $id
    ) {
        return LendRecord::with(
            [
                'account' => function (Relation $builder) {
                    $builder->withTrashed();
                }
            ]
        )
            ->where('lend_records.id', $id)
            ->first();
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @param int|null $lendState
     * @param string|null $keyword
     * @return Builder
     */
    private function builderLendRecordQuery(
        string $startDate,
        string $endDate,
        int $userId = null,
        int $lendState = null,
        string $keyword = null
    ) {
        $builder = LendRecord::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(
                [
                    'account' => function (Relation $builder) use ($userId, $keyword) {
                        $builder->withTrashed();
                    },
                    'user'    => function (Relation $builder) {
                        $builder->select(
                            [
                                'id',
                                'email',
                                'status',
                                'apply_status',
                                'QQ_id',
                                'company_name',
                                'mobile',
                                'account_id',
                                'lend_fee',
                                'last_login',
                                'created_at',
                                'updated_at',
                                'deleted_at'
                            ]
                        );
                    }
                ]
            );
        if (!is_null($userId)) {
            $builder->where('user_id', '=', $userId);
        }
        if (!is_null($lendState)) {
            $builder->where('lend_state', $lendState);
        }
        if (!is_null($keyword)) {
            $builder->where(function (Builder $builder) use ($keyword) {
                $builder->where('record_seq', $keyword)->orWhereHas(
                    'account',
                    function (Builder $builder) use ($keyword) {
                        $builder->where('accounts.account', $keyword);
                    }
                );
            });
        }

        return $builder;
    }

    /**
     * @param User $user
     * @param string $code
     * @return verifyCode|null
     */
    public function findValidateCode(User $user, string $code)
    {
        $result = null;
        try {
            $result = $user->verifyCodes()
                ->where('code', $code)
                ->where('type', VerifyType::LEND_LIST)
                ->first();
        } catch (\Exception $e) {
            \Log::log('debug', $e->getMessage());
        }

        return $result;
    }
}
