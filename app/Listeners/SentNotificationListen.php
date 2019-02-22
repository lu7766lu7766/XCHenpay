<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/20
 * Time: 下午 06:19
 */

namespace App\Listeners;

use App\Contract\Information\INotify;
use App\Repositories\InformationCategoryRepo;
use App\Service\InformationManageService;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class SentNotificationListen
{
    /**
     * @param INotify $event
     * @return bool
     */
    public function handle(INotify $event)
    {
        $category = app(InformationCategoryRepo::class)->findCode($event->getCategoryCode());
        $info = null;
        if (!is_null($category)) {
            $service = InformationManageService::getInstance();
            $info = $service->create(
                $category->getKey(),
                $event->getSubject(),
                $event->getContent()
            );
            if (ArrayMaster::isList($event->getRoleSlug())) {
                $service->attachRoles($info, $event->getRoleSlug());
            }
            if (!is_null($event->getUserId())) {
                $service->attachUser($info, $event->getUserId());
            }
        }

        return !is_null($info);
    }
}
