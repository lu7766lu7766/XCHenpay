<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthcodesPaymentAccountTable extends Migration
{
    private $table = 'authcodes_payment_account';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->unsignedInteger('authcodes_id');
            $table->unsignedInteger('payment_account_id');
            // index
            $table->index(['authcodes_id', 'payment_account_id'], 'idx_authcodes_id_payment_account_id');
            // foreign key
            $table->foreign('authcodes_id', 'fk_' . $this->table . '_authcodes_id')
                ->references('id')->on('authcodes')->onDelete('cascade');
            $table->foreign('payment_account_id', 'fk_' . $this->table . '_payment_account_id')
                ->references('id')->on('user_payment_account')->onDelete('cascade');
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
