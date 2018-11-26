<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/11/22
 * Time: 下午 04:13
 */

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class BankAccountRep
{
    /**
     * @param int $userId
     * @param int|null $id
     * @return Collection|Account[]
     */
    public function findUser(int $userId, int $id = null)
    {
        $query = Account::query()->where('user_id', $userId);
        if (!is_null($id)) {
            $query->where('id', $id);
        }

        return $query->get();
    }
}
