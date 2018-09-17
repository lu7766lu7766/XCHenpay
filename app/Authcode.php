<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authcode extends Model
{
    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function i6payment()
    {
        return $this->belongsTo(Payment::class, 'payment_type', 'i6pay_id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_service_id', 'company_service_id');
    }

    public function tradeType()
    {
        return $this->belongsTo(TradeType::class, 'trade_type', 'id');      //todo 覺得小怪感覺key應該反過來，卻這樣才會過
    }
}
