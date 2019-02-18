<?php
/**
 * Created by PhpStorm.
 * User: derek
 * Date: 2019/1/21
 * Time: 下午 06:13
 */

namespace App\Models;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Role
 * @property Collection|InformationNotify[] informationNotify
 * @package App\Models
 */
class Role extends EloquentRole
{
    /**
     * @return BelongsToMany
     */
    public function informationNotify()
    {
        return $this->morphToMany(
            InformationNotify::class,
            'relate',
            'information_notify_relation',
            'relate_id',
            'information_notify_id',
            'id'
        )->withTimestamps();
    }
}
