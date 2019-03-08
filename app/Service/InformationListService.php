<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/21
 * Time: 下午 02:51
 */

namespace App\Service;

use App\Http\Requests\Information\Lists\InformationListsDeleteRequest;
use App\Http\Requests\Information\Lists\InformationListsIndexRequest;
use App\Http\Requests\Information\Lists\InformationListsInfoRequest;
use App\Http\Requests\Information\Lists\InformationListsTotalRequest;
use App\Models\InformationCategory;
use App\Models\InformationNotify;
use App\Repositories\InformationCategoryRepo;
use App\Repositories\InformationNotifyListRepo;
use App\Traits\Singleton;
use App\User;
use Illuminate\Support\Collection;

class InformationListService
{
    use Singleton;
    /** @var User */
    private $user;

    /**
     * @param User $user
     */
    public function init(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param \App\Http\Requests\Information\Lists\InformationListsIndexRequest $request
     * @return InformationNotify[]|Collection
     */
    public function list(InformationListsIndexRequest $request)
    {
        return app(InformationNotifyListRepo::class)->list(
            $this->user->getKey(),
            $request->getCategoryId(),
            $request->getPage(),
            $request->getPerPage(),
            $request->getRead()
        );
    }

    /**
     * @param \App\Http\Requests\Information\Lists\InformationListsTotalRequest $request
     * @return int
     */
    public function total(InformationListsTotalRequest $request)
    {
        return app(InformationNotifyListRepo::class)->total(
            $this->user->getKey(),
            $request->getCategoryId(),
            $request->getRead()
        );
    }

    /**
     * @param \App\Http\Requests\Information\Lists\InformationListsInfoRequest $request
     * @return InformationNotify|null
     */
    public function info(InformationListsInfoRequest $request)
    {
        return app(InformationNotifyListRepo::class)->createUserInformation($request->getId(), $this->user->getKey());
    }

    /**
     * @param InformationListsDeleteRequest $request
     * @return bool
     */
    public function delete(InformationListsDeleteRequest $request)
    {
        $result = app(InformationNotifyListRepo::class)->deleteUserInformation(
            $request->getId(),
            $this->user->getKey()
        );

        return $result;
    }

    /**
     * @return InformationCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function category()
    {
        return app(InformationCategoryRepo::class)->all();
    }

    /**
     * @return int
     */
    public function unreadCount()
    {
        return app(InformationNotifyListRepo::class)->total($this->user->getKey(), null, false);
    }
}
