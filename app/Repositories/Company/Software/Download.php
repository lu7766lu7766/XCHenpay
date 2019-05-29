<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 2019/5/24
 * Time: 下午 03:49
 */

namespace App\Repositories\Company\Software;

use App\Constants\Common\StatusConstants;
use App\Models\SoftwareCategory;
use Illuminate\Database\Eloquent\Relations\Relation;

class Download
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|SoftwareCategory
     */
    public function getData()
    {
        try {
            $result = SoftwareCategory::query()
                ->with([
                    'software' => function (Relation $builder) {
                        $builder->where('software.status', StatusConstants::YES)->orderBy('software.id', 'DESC');
                    }
                ])
                ->where('status', StatusConstants::YES)
                ->orderBy('sort', 'ASC')
                ->get();
        } catch (\Throwable $e) {
            $result = collect();
            logger($e->getMessage());
        }

        return $result;
    }
}
