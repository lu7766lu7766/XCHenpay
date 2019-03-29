<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2018/12/19
 * Time: 下午 12:18
 */

namespace App\Service;

use App\Contract\Information\INotify;
use App\Events\Information\Notify\WhiteListEdited;
use App\Http\Requests\Whitelist\WhitelistDeleteRequest;
use App\Http\Requests\Whitelist\WhitelistIndexRequest;
use App\Http\Requests\Whitelist\WhitelistInfoRequest;
use App\Http\Requests\Whitelist\WhitelistStoreRequest;
use App\Models\Whitelist;
use App\Repositories\UserRepo;
use App\Repositories\WhitelistRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Support\Collection;

class WhitelistService
{
    use Singleton;

    /**
     * @param WhitelistIndexRequest $request
     * @return User[]|Collection
     */
    public function list(WhitelistIndexRequest $request)
    {
        return app(UserRepo::class)
            ->getWhitelist($request->getPage(), $request->getPerPage())
            ->map(function (User $item) {
                return $item->setVisible([
                    'id',
                    'company_name',
                    'company_service_id',
                    'whitelist'
                ]);
            })
            ->all();
    }

    /**
     * @return array
     */
    public function total()
    {
        return ['count' => app(UserRepo::class)->total()];
    }

    /**
     * @param WhitelistInfoRequest $request
     * @return Whitelist|null
     */
    public function info(WhitelistInfoRequest $request)
    {
        return app(WhitelistRepo::class)->findByUser($request->getUserId());
    }

    /**
     * @param WhitelistStoreRequest $request
     * @return Whitelist
     */
    public function createOrUpdate(WhitelistStoreRequest $request)
    {
        $data = ['ip' => $request->getIps()];
        $result = app(WhitelistRepo::class)->createOrUpdate($request->getUserId(), $data);
        event(INotify::class, new WhiteListEdited($result));

        return $result;
    }

    /**
     * @param WhitelistDeleteRequest $request
     * @return array
     */
    public function delete(WhitelistDeleteRequest $request)
    {
        return ['count' => app(WhitelistRepo::class)->delete($request->getUserId())];
    }
}
