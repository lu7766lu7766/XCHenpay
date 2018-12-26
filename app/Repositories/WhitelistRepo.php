<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/19
 * Time: 下午 01:25
 */

namespace App\Repositories;

use App\Models\Whitelist;
use Illuminate\Database\Eloquent\Model;

class WhitelistRepo
{
    /**
     * @param $userId
     * @return Whitelist|null
     */
    public function findByUser($userId)
    {
        return Whitelist::where('user_id', $userId)->first();
    }

    /**
     * @param int $userId
     * @param array $data
     * @return Model|Whitelist
     */
    public function createOrUpdate(int $userId, array $data)
    {
        return Whitelist::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }

    /**
     * @param int $userId
     * @return int
     */
    public function delete(int $userId)
    {
        try {
            $result = Whitelist::query()->where('user_id', $userId)->delete();
        } catch (\Throwable $e) {
            $result = 0;
        }

        return $result;
    }
}
