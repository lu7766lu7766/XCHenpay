<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

class User extends EloquentUser {

    use Taggable;
    use SoftDeletes;

    protected $table = 'users';
	protected $fillable = [];
	protected $guarded = ['id'];
	protected $hidden = ['password', 'remember_token'];
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
