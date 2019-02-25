<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Account
 * @property int $id
 * @property int user_id
 * @property string name
 * @property string account
 * @property string bank_name
 * @property string bank_branch
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 * @property string status
 * @property string note
 * @package App\Models
 */
class Account extends Model
{
    protected $guarded = [];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function lendRecords()
    {
        return $this->hasMany(LendRecord::class, 'account_id', 'id');
    }
}
