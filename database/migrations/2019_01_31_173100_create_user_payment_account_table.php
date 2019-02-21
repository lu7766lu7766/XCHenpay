<?php

use App\Constants\PaymentManage\PaymentManageDepositTypeConstants;
use App\Constants\PaymentManage\PaymentManageStatusConstants;
use App\Constants\PaymentManage\PaymentManageVendorsCodeConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPaymentAccountTable extends Migration
{
    private $table = 'user_payment_account';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->comment('名稱');
            $table->enum('status', PaymentManageStatusConstants::enum())->comment('狀態,on:開啟/off:關閉');
            $table->enum('vendor', PaymentManageVendorsCodeConstants::enum())->comment('金流來源');
            $table->unsignedInteger('user_id')->nullable()->comment('商戶id');
            $table->unsignedMediumInteger('max_deposit')->comment('最高儲值金額');
            $table->unsignedMediumInteger('min_deposit')->comment('最低儲值金額');
            $table->unsignedMediumInteger('total_deposit')->comment('總儲值金額');
            $table->unsignedMediumInteger('withdraw')->comment('顯示提領提示金額');
            $table->enum('deposit_type', PaymentManageDepositTypeConstants::enum())->comment('總儲值類型');
            $table->text('conn_config')->nullable()->comment('金流連線資訊');
            $table->timestamps();
            $table->index(['vendor', 'user_id'], 'idx_code_user_id');
            // foreign key
            $table->foreign('user_id', 'fk_' . $this->table . '_user_id')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists($this->table);
        DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
