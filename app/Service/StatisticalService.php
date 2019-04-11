<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/4/10
 * Time: 下午 06:10
 */

namespace App\Service;

use App\Http\Requests\SearchReportStatQueryRequest;
use App\Repositories\AuthCodes;
use App\Traits\Singleton;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class StatisticalService
{
    use Singleton;
    /** @var $user User */
    private $user;

    /**
     * @param User $user
     */
    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param SearchReportStatQueryRequest $handle
     * @return User[]|Collection
     */
    public function list(SearchReportStatQueryRequest $handle)
    {
        return app(AuthCodes::class)->getReportRecord(
            $handle->getStartDate(),
            $handle->getEndDate(),
            $this->user->company_service_id
        );
    }
}
