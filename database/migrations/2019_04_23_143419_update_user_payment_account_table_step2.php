<?php

use App\Constants\PaymentManage\PaymentManageVendorsCodeConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;
use XC\Independent\Kit\Support\Scalar\ArrayMaster;

class UpdateUserPaymentAccountTableStep2 extends Migration
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
        $enum = "'" . PaymentManageVendorsCodeConstants::implodeEnum("','") . "'";
        \DB::connection()->statement(
            "ALTER TABLE {$this->table}
             MODIFY COLUMN  vendor ENUM({$enum})
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
        $enum = Arr::where(PaymentManageVendorsCodeConstants::enum(), function ($val) {
            return $val !== PaymentManageVendorsCodeConstants::ALI_PAY_PERSONAL_PAYEE;
        });
        $enum = "'" . ArrayMaster::implode($enum, "','") . "'";
        \DB::connection()->statement(
            "ALTER TABLE {$this->table}
             MODIFY COLUMN  vendor ENUM({$enum})
             Comment '金流來源' NOT NULL"
        );
    }
}
