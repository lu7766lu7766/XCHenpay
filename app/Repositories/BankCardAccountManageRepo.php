<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/14
 * Time: 下午 03:55
 */

namespace App\Repositories;

use App\Constants\Roles\RolesConstants;
use App\Models\BankCardAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

class BankCardAccountManageRepo
{
    /**
     * @param int|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function listQuery(int $userId = null)
    {
        return BankCardAccount::query()->whereHas('personal', function (Builder $query) use ($userId) {
            if (!is_null($userId)) {
                $query->where('users.id', $userId);
            }
            $query->whereHas('roles', function (Builder $subQuery) {
                $subQuery->where('roles.slug', RolesConstants::USER);
            });
        });
    }

    /**
     * @param int|null $userId
     * @param string|null $status
     * @param string|null $search
     * @param int $page
     * @param int $perpage
     * @return Collection|BankCardAccount[]
     */
    public function list(
        int $userId = null,
        string $status = null,
        string $search = null,
        int $page = 1,
        int $perpage = 25
    ) {
        $query = $this->listQuery($userId)
            ->with([
                'payment',
                'personal' => function (Relation $query) {
                    $query->select([
                        $query->getRelated()->qualifyColumn('id'),
                        $query->getRelated()->qualifyColumn('company_name'),
                        $query->getRelated()->qualifyColumn('company_service_id'),
                    ]);
                }
            ]);
        if (!is_null($status)) {
            $query->where('status', $status);
        }
        if (!is_null($search)) {
            $query->where(function (Builder $subQuery) use ($search) {
                $subQuery->where('user_name', 'like', '%' . $search . '%')
                    ->orWhere('card_no', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('id', 'DESC')->forPage($page, $perpage)->get();
    }

    /**
     * @param int|null $userId
     * @param string|null $status
     * @param string|null $search
     * @return int
     */
    public function total(int $userId = null, string $status = null, string $search = null)
    {
        $query = $this->listQuery($userId);
        if (!is_null($status)) {
            $query->where('status', $status);
        }
        if (!is_null($search)) {
            $query->where(function (Builder $subQuery) use ($search) {
                $subQuery->where('user_name', 'like', '%' . $search . '%')
                    ->orWhere('card_no', 'like', '%' . $search . '%');
            });
        }

        return $query->count();
    }

    /**
     * @param int $id
     * @return BankCardAccount|null
     */
    public function info(int $id)
    {
        return $this->listQuery()->with([
            'payment',
            'personal' => function (Relation $query) {
                $query->select([
                    $query->getRelated()->qualifyColumn('id'),
                    $query->getRelated()->qualifyColumn('company_name'),
                    $query->getRelated()->qualifyColumn('company_service_id'),
                ]);
            }
        ])->where('id', $id)->first();
    }
}
