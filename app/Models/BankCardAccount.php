<?php

namespace App\Models;

use App\Pivot\BankCardGateway;
use App\Pivot\PaymentBankAccount;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;

/**
 * Class BankCardPayment
 * @package App\Models
 * @property string user_name
 * @property string card_no
 * @property string bank_name
 * @property string status
 * @property int total_amount
 * @property int minimum_amount
 * @property int maximum_amount
 * @property string settle_date
 * @property User[]|Collection personal
 * @property Payment[]|Collection payment
 * @property BankCardGateway gatewayUri
 */
class BankCardAccount extends Model
{
    protected $table = 'bank_card_account';
    protected $fillable = [
        'user_name',
        'card_no',
        'bank_name',
        'status',
        'total_amount',
        'minimum_amount',
        'maximum_amount',
        'settle_date',
    ];
    protected $casts = [];

    /**
     * @return BelongsToMany
     */
    public function personal()
    {
        return $this->belongsToMany(User::class, 'bank_card_account_users', 'bank_card_account_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function payment()
    {
        return $this->belongsToMany(
            Payment::class,
            'payment_bank_card_account',
            'bank_card_account_id',
            'payment_id',
            'id',
            'i6pay_id'
        )->as('payment_information')->using(PaymentBankAccount::class)->withPivot('payment_detail');
    }
}
