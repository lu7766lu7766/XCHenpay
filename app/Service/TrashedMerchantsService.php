<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/24
 * Time: 下午 06:14
 */

namespace App\Service;

use App\Http\Requests\TrashedMerchant\TrashedMerchantsIndexRequest;
use App\Http\Requests\TrashedMerchant\TrashedMerchantsRestoreRequest;
use App\Repositories\ActivityRepository;
use App\Repositories\UserRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Support\Collection;
use Sentinel;

class TrashedMerchantsService
{
    use Singleton;

    /**
     * @param TrashedMerchantsIndexRequest $request
     * @return User[]|Collection
     */
    public function list(TrashedMerchantsIndexRequest $request)
    {
        return app(UserRepo::class)->getTrashedMerchants($request->getPage(), $request->getPerPage());
    }

    /**
     * @param TrashedMerchantsRestoreRequest $request
     * @return bool
     */
    public function restore(TrashedMerchantsRestoreRequest $request)
    {
        try {
            $result = false;
            \DB::transaction(
                function () use ($request, &$result) {
                    $targetUser = app(UserRepo::class)->restore($request->getId());
                    if (!is_null($targetUser)) {
                        /** @var User $user */
                        $user = Sentinel::getUser();
                        app(ActivityRepository::class)
                            ->addActivityLog($targetUser->email, $targetUser, 'User restored by ' . $user->email);
                        $result = true;
                    }
                }
            );
        } catch (\Throwable $e) {
            \Log::error('file:' . $e->getFile() . 'line:' . $e->getLine() . 'message:' . $e->getMessage());
        }

        return $result;
    }

    /**
     * @return int
     */
    public function total()
    {
        return app(UserRepo::class)->getTrashedMerchantsTotal();
    }
}
