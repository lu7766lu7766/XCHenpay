<?php

use App\Constants\Common\StatusConstants;
use App\Constants\Payment\PaymentConstants;
use App\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentTableSetp1 extends Migration
{
    private $table = 'payments';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->enum('is_lend', StatusConstants::enum())
                ->comment('是否可下發')->default(StatusConstants::YES);
        });
        /** @var Payment|null $payment */
        $payment = Payment::query()->where('i6pay_id', PaymentConstants::ALI_PAY_BANK_CARD_PERSONAL_CODE)->first();
        if (!is_null($payment)) {
            $payment->update(['is_lend' => StatusConstants::NO]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('is_lend');
        });
    }
}
