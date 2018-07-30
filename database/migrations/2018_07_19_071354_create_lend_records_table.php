<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLendRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lend_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('record_seq')->unique();
            $table->integer('user_id');
            $table->integer('account_id');
            $table->float('amount', 50,6);
            $table->float('fee', 50,6);
            $table->integer('lend_state');
            $table->string('lend_summary');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lend_records');
    }
}
