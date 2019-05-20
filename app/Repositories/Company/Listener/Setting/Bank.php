<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/16
 * Time: 下午 12:30
 */

namespace App\Repositories\Company\Listener\Setting;

use App\Models\Bank as Model;
use Illuminate\Database\Eloquent\Collection;

class Bank
{
    /**
     * @return Bank|Collection
     */
    public function all()
    {
        try {
            $result = Model::all();
        } catch (\Throwable $e) {
            $result = collect();
            logger($e->getMessage());
        }

        return $result;
    }
}
