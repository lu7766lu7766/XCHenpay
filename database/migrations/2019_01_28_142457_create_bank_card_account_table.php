<?php

use App\Constants\BankCardPayment\BankCardPaymentSettleDateConstants;
use App\Constants\BankCardPayment\BankCardPaymentStatusConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankCardAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_card_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name', 10)->comment('銀行卡用戶名');
            $table->string('card_no', 20)->comment('銀行卡號');
            $table->string('bank_name', 10)->comment('銀行名稱');
            $table->enum('status', BankCardPaymentStatusConstants::enum())->comment('狀態 Y:啟用 N:關閉');
            $table->integer('total_amount')->nullable()->comment('總儲值金額');
            $table->integer('minimum_amount')->nullable()->comment('最低金額');
            $table->integer('maximum_amount')->nullable()->comment('最高金額');
            $table->enum('statistics_type', BankCardPaymentSettleDateConstants::enum())->nullable()->comment('統計類型');
            $table->timestamps();
            //index
            $table->index('user_name', 'idx_user_name');
            $table->index('card_no', 'idx_card_no');
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
        Schema::dropIfExists('bank_card_account');
        \DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

