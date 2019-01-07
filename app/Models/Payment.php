<?php

namespace App\Models;

use Cartalyst\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class PaymentFee
 * @package App\Models
 * @property Collection|PaymentFees[] paymentFee
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
}
