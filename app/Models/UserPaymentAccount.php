<?php
/**
 * Created by PhpStorm.
 * User: ed
 * Date: 2019/2/11
 * Time: 下午 02:56
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserPaymentAccount extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_payment_account';
    /**
     * @var array
     */
    protected $hidden = [
        'conn_config'
    ];
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'status',
        'vendor',
        'max_deposit',
        'min_deposit',
        'total_deposit',
        'withdraw',
        'deposit_type',
        'conn_config'
    ];
    /**
     * @var array
     */
    protected $casts = [
        'conn_config' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authcodes()
    {
        return $this->belongsToMany(Authcode::class, 'authcodes_payment_account', 'payment_account_id', 'authcodes_id');
    }
}
