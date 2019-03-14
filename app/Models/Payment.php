<?php

namespace App\Models;

use App\Constants\PaymentFee\PaymentFeeStatusConstants;
use App\Pivot\PaymentBankAccount;
use App\User;
use Cartalyst\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class PaymentFee
 * @package App\Models
 * @property Collection|User[] userFee
 * @property BankCardAccount[]|Collection bankAccount
 * @property PaymentBankAccount payment_information
 */
class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return BelongsToMany
     */
    public function userFee()
    {
        return $this->belongsToMany(User::class, 'payment_fees', 'payment_id', 'user_id')->withPivot(['fee', 'status']);
    }

    /**
     * @return BelongsToMany
     */
    public function userClosedPayment()
    {
        return $this->belongsToMany(User::class, 'payment_fees', 'payment_id', 'user_id')
            ->wherePivot('status', PaymentFeeStatusConstants::OFF);
    }

    /**
     * @return BelongsToMany
     */
    public function bankAccount()
    {
        return $this->belongsToMany(
            BankCardAccount::class,
            'payment_bank_card_account',
            'payment_id',
            'bank_card_account_id',
            'i6pay_id'
        )->as('payment_information')->using(PaymentBankAccount::class)->withPivot('payment_detail');
    }
}
