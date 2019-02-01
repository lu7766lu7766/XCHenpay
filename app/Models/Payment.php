<?php

namespace App\Models;

use App\Pivot\PaymentBankAccount;
use Cartalyst\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PaymentFee
 * @package App\Models
 * @property Collection|PaymentFees[] paymentFee
 * @property BankCardAccount[]|Collection bankAccount
 */
class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function paymentFee()
    {
        return $this->hasMany(PaymentFees::class, 'payment_id', 'id');
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
