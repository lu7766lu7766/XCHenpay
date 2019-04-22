<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUserPaymentAccountTableStep1 extends Migration
{
    /** @var string $table */
    private $table = 'user_payment_account';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::connection()->statement(
            "ALTER TABLE {$this->table}
             MODIFY COLUMN  vendor ENUM('aliPay','weChatPay','unionPay','qqPay','aliPayRedEnvelop','aliPayPersonalBankAccount','weChatPayeeQRCode','QuickPassPayeeQRCode')
             Comment '金流來源' NOT NULL"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::connection()->statement(
            "ALTER TABLE {$this->table}
             MODIFY COLUMN  vendor ENUM('aliPay','weChatPay','unionPay','qqPay') Comment '金流來源' NOT NULL
             "
        );
    }
}
