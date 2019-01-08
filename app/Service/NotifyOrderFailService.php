<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/26
 * Time: 下午 04:21
 */

namespace App\Service;

use App\Http\Requests\OrderFail\NotifyOrderFailIndexRequest;
use App\Http\Requests\OrderFail\NotifyOrderFailTotalRequest;
use App\Models\ErrorLog;
use App\Repositories\NotifyOrderFailRepo;
use App\Traits\Singleton;
use Illuminate\Database\Eloquent\Collection;

class NotifyOrderFailService
{
    use Singleton;

    /**
     * @param NotifyOrderFailIndexRequest $request
     * @return ErrorLog[]|Collection
     */
    public function list(NotifyOrderFailIndexRequest $request)
    {
        return app(NotifyOrderFailRepo::class)->list(
            $request->getStartTime(),
            $request->getEndTime(),
            $request->getKeyword(),
            $request->getPage(),
            $request->getPerPage()
        );
    }

    /**
     * @param NotifyOrderFailTotalRequest $request
     * @return int
     */
    public function total(NotifyOrderFailTotalRequest $request)
    {
        return app(NotifyOrderFailRepo::class)->total(
            $request->getStartTime(),
            $request->getEndTime(),
            $request->getKeyword()
        );
    }
}
