<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PaymentWindow
 * @package App\Models
 * @property int authcode_id
 * @property string entrance
 * @property Authcode order
 */
class PaymentWindow extends Model
{
    protected $table = 'payment_window';
    protected $fillable = ['authcode_id', 'entrance'];

    /**
     * @return BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Authcode::class, 'authcode_id');
    }
}
