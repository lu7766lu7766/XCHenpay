<?php

namespace App;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Authcode;
use App\Models\InformationNotify;
use App\Models\LendRecord;
use App\Models\PaymentFees;
use App\Models\Role;
use App\Models\UserPaymentAccount;
use App\Models\verifyCode;
use App\Models\Whitelist;
use Cartalyst\Sentinel\Users\EloquentUser;
use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Class User
 * @property int id
 * @property string company_service_id
 * @property double lend_fee
 * @property string email
 * @property string apply_status
 * @property string mobile
 * @package App
 * @property string company_name
 * @property Collection|Account[] accounts
 * @property Whitelist|null whitelist
 * @property string status
 * @property string password
 * @property string secret_code
 * @property Collection|Role[] roles
 * @method bool hasAccess(array | string $permissions)
 * @method bool hasAnyAccess(array | string $permissions)
 * @mixin Builder
 */
class User extends EloquentUser implements AuthenticatableContract
{
    use Authorizable;
    use Authenticatable;
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
    protected $loginNames = ['email', 'status'];
    protected static $rolesModel = Role::class;

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

    public function lendRecords()
    {
        return $this->hasMany(LendRecord::class, 'user_id', 'id');
    }

    public function tradeLogs()
    {
        return $this->hasMany(Authcode::class, 'company_service_id', 'company_service_id');
    }

    /**
     * @return MorphMany
     */
    public function activityLogs()
    {
        return $this->morphMany(Activity::class, 'causer');
    }

    /**
     * @return HasOne
     */
    public function whitelist()
    {
        return $this->hasOne(WhiteList::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userPaymentAccount()
    {
        return $this->hasMany(UserPaymentAccount::class, 'user_id', 'id');
    }

    /**
     * @return MorphMany
     */
    public function informationNotify()
    {
        return $this->morphMany(InformationNotify::class, 'owner');
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return '';
    }
}
