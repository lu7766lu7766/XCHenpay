<?php

namespace App\Repositories;

use App\Models\LendRecord;
use Illuminate\Database\Eloquent\Builder;
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
}
