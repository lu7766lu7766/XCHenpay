<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentBankCardAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_bank_card_account', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_id');
            $table->unsignedInteger('bank_card_account_id');
            $table->json('payment_detail')->nullable()->comment('支付轉銀行卡細節');
            //unique
            $table->unique(
                ['payment_id', 'bank_card_account_id'],
                'payment_id_bank_card_account_id_unique'
            );
            //foreign key
            $table->foreign('payment_id', 'fk_payment_bank_card_account_payment_id')
                ->references('i6pay_id')->on('payments')->onDelete('cascade');
            $table->foreign('bank_card_account_id', 'fk_payment_bank_card_account_bank_card_account_id')
                ->references('id')->on('bank_card_account')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('payment_bank_card_account');
        \DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
