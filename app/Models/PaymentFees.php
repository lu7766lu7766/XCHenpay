<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentFees extends Model
{
    protected $table = 'payment_fees';
    protected $fillable = [
        'user_id',
        'payment_id',
        'fee',
        'status'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }
}
