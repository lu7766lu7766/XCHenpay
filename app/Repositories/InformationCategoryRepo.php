<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/2/1
 * Time: 下午 12:32
 */

namespace App\Repositories;

use App\Models\InformationCategory;
use Illuminate\Database\Eloquent\Collection;

class InformationCategoryRepo
{
    /**
     * @return InformationCategory[]|Collection
     */
    public function all()
    {
        return InformationCategory::all();
    }
}
