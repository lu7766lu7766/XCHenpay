<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/11/20
 * Time: 下午 06:44
 */

namespace App\Service;

use App\Http\Requests\ActivityHistoryRequest;
use App\Repositories\ActivityRepository;
use App\Traits\Singleton;
use App\User;

class ActivityHistoryService
{
    use Singleton;

    /**
     * @param ActivityHistoryRequest $request
     * @param int|null $userId if give this value, will return this user history.
     * @return array
     */
    public function getRecords(ActivityHistoryRequest $request, int $userId = null)
    {
        $user = \App::make(ActivityRepository::class)->getCauserLog(
            $request->getStart(),
            $request->getEnd(),
            User::class,
            $request->getSort(),
            $request->getKeyword(),
            $userId,
            $request->getPage(),
            $request->getPerpage()
        );
        $result = [];
        foreach ($user as $activity) {
            $data = $activity->attributesToArray();
            $data['user'] = [
                'email' => $activity->causer->email,
                'name'  => $activity->causer->company_name,
            ];
            $result[] = $data;
        }

        return $result;
    }

    /**
     * @param ActivityHistoryRequest $request
     * @param int|null $userId
     * @return int
     */
    public function getRecordsTotal(ActivityHistoryRequest $request, int $userId = null)
    {
        $result = \App::make(ActivityRepository::class)->getCauserLogTotal(
            $request->getStart(),
            $request->getEnd(),
            User::class,
            $request->getKeyword(),
            $userId
        );

        return $result;
    }
}
