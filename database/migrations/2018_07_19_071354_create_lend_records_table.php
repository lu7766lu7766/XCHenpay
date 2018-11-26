<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->decimal('amount', 16, 6);
            $table->decimal('fee', 16, 6)->default(0);
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
