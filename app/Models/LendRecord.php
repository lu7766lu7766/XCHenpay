<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LendRecord
 * @package App\Models
 * @property string record_seq
 * @property int lend_state
 * @property User|null user
 * @property Account|null account
 * @property float amount
 * @property string review_note
 * @property int user_id
 */
class LendRecord extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
