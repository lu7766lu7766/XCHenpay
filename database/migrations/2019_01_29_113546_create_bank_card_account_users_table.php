<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankCardAccountUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_card_account_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('bank_card_account_id');
            $table->timestamps();
            $table->unique(
                ['user_id', 'bank_card_account_id'],
                'user_id_bank_card_account_id_unique'
            );
            //foreign key
            $table->foreign('user_id', 'fk_bank_card_account_users_user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bank_card_account_id', 'fk_bank_card_account_users_bank_card_account_id')
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
        Schema::dropIfExists('bank_card_account_users');
        \DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
