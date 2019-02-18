<?php

namespace App\Models;

use App\Pivot\UserInformationNotify;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class InformationNotify
 * @package App\Models
 * @property InformationCategory category
 * @property Collection|Role[] roleGroup
 * @property Collection|User[] personal
 */
class InformationNotify extends Model
{
    protected $table = 'information_notify';
    protected $fillable = [
        'category_id',
        'subject',
        'content',
    ];

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(InformationCategory::class, 'category_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function roleGroup()
    {
        return $this->morphedByMany(Role::class, 'relate', 'information_notify_relation')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function personal()
    {
        return $this->morphedByMany(User::class, 'relate', 'information_notify_relation')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function beenDeleteByUser()
    {
        return $this->belongsToMany(
            User::class,
            'user_information',
            'information_notify_id',
            'user_id',
            'id',
            'id'
        )->wherePivot('deleted_at', '!=', null)->using(UserInformationNotify::class)->withPivot([
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }

    /**
     * @return BelongsToMany
     */
    public function seenByUser()
    {
        return $this->belongsToMany(
            User::class,
            'user_information',
            'information_notify_id',
            'user_id',
            'id',
            'id'
        )->using(UserInformationNotify::class)->withPivot([
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
    }
}
