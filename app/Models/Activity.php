<?php
/**
 * Created by PhpStorm.
 * User: House
 * Date: 2018/11/19
 * Time: 下午 01:27
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

/**
 * Class Activity
 * @package App\Models
 * @property User causer
 */
class Activity extends SpatieActivity
{
    protected $hidden = [
        'subject_type',
        'causer_type',
        'subject_id',
        'causer_id',
    ];

    /**
     * @return MorphTo
     */
    public function causerWithTrashed(): MorphTo
    {
        return parent::causer()->withTrashed();
    }
}
