<?php

namespace App;

use App\Models\PaymentFees;
use Cartalyst\Sentinel\Permissions\StrictPermissions;
use Cartalyst\Sentinel\Users\EloquentUser;
use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App
 * @mixin StrictPermissions|Builder
 */
class User extends EloquentUser
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes to be fillable from the model.
     *
     * A dirty hack to allow fields to be fillable by calling empty fillable array
     *
     * @var array
     */
    use Taggable;
    protected $fillable = [];
    protected $guarded = ['id'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    /**
     * To allow soft deletes
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function fees()
    {
        return $this->hasMany(PaymentFees::class);
    }

    public function attachCode(verifyCode $code)
    {
        $this->verifyCodes()->save($code);
    }

    public function addAccount(Account $account)
    {
        $this->accounts()->save($account);
    }

    public function addLendRecord(LendRecord $record)
    {
        return $this->lendRecords()->save($record);
    }

    public function verifyCodes()
    {
        return $this->hasMany(verifyCode::class, 'user_id', 'id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'user_id', 'id');
    }

    public function LendRecords()
    {
        return $this->hasMany(LendRecord::class, 'user_id', 'id');
    }

    public function tradeLogs()
    {
        return $this->hasMany(Authcode::class, 'company_service_id', 'company_service_id');
    }
}
