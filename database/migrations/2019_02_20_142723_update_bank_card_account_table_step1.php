<?php

use Illuminate\Database\Migrations\Migration;

class UpdateBankCardAccountTableStep1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::connection()->statement(
            "ALTER TABLE bank_card_account 
             MODIFY COLUMN  statistics_type ENUM('day','week','month') DEFAULT 'day' NOT NULL,
             MODIFY COLUMN minimum_amount INTEGER DEFAULT 0 NOT NULL,
             MODIFY COLUMN total_amount INTEGER DEFAULT 0 NOT NULL,
             MODIFY COLUMN maximum_amount INTEGER DEFAULT 0 NOT NULL;"
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
            "ALTER TABLE bank_card_account 
             MODIFY COLUMN  statistics_type ENUM('day','week','month') NULL,
             MODIFY COLUMN minimum_amount INTEGER NULL,
             MODIFY COLUMN total_amount INTEGER  NULL,
             MODIFY COLUMN maximum_amount INTEGER  NULL;"
        );
    }
}
