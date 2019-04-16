<?php

namespace App\Models;

use App\Constants\TradeTypesConstants;
use App\Pivot\BankCardGateway;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Authcode
 * @package App\Models
 * @property int id
 * @property int pay_state
 * @property string pay_summary
 * @property string auth_code
 * @property string trade_seq
 * @property string company_service_id
 * @property string trade_service_id
 * @property string trade_type
 * @property string customer_id
 * @property string item_code
 * @property string item_name
 * @property float amount
 * @property float fee
 * @property int currency_id
 * @property string nonce_str
 * @property string finish_url
 * @property string notify_url
 * @property string account
 * @property int payment_type
 * @property TradeType tradeType
 * @property User company
 * @property Carbon created_at
 * @property float real_paid_amount
 * @property PaymentWindow|null paymentWindow
 * @property float rand_fee
 */
class Authcode extends Model
{
    protected $fillable = [
        'pay_state',
        'pay_summary',
        'trade_service_id',
        'amount',
        'fee',
        'payment_type',
        'pay_start_time',
        'pay_end_time',
        'trade_type',
        'currency_id',
        'remark',
        'real_paid_amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @deprecated
     */
    public function i6payment()
    {
        return $this->belongsTo(Payment::class, 'payment_type', 'i6pay_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->i6payment();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(User::class, 'company_service_id', 'company_service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tradeType()
    {
        return $this->belongsTo(TradeType::class, 'trade_type', 'id');
    }

    /**
     * @return $this
     */
    public function fillCopyTime()
    {
        if ($this->tradeType->name == TradeTypesConstants::FILL_ORDER) {
            $this->setCreatedAt($this->pay_end_time);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bankCardAccount()
    {
        return $this->belongsToMany(BankCardAccount::class, 'bank_card_gateway', 'authcode_id', 'bank_card_id')
            ->using(BankCardGateway::class)->withPivot('uri')->as('gatewayUri');
    }

    /**
     * @return HasOne
     */
    public function paymentWindow()
    {
        return $this->hasOne(PaymentWindow::class, 'authcode_id');
    }

    public function authCodesPaymentAccount()
    {
        return $this->belongsToMany(
            UserPaymentAccount::class,
            'authcodes_payment_account',
            'authcodes_id',
            'payment_account_id'
        );
    }

    /**
     * 產生隨機金額
     * @return Authcode
     */
    public function createRandomFee()
    {
        if ($this->rand_fee == 0) {
            $this->rand_fee = rand(1, 9) * 0.01;
        }

        return $this;
    }

    /**
     * 應付金額
     * @return float
     */
    public function amountPayable()
    {
        return bcsub($this->amount, $this->rand_fee, 2);
    }
}
