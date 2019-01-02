<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Authcode
 * @package App\Models
 * @property string trade_seq
 * @property string trade_type
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
        'remark'
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
}
