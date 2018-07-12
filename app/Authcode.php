<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authcode extends Model
{
    protected $guarded = [];

    public function verifyCode()
    {
        return $this->hasOne(verifyCode::class, 'id', 'verifyCode_id');
    }

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


}
