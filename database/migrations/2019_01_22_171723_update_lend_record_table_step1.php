<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLendRecordTableStep1 extends Migration
{
    private $table = 'lend_records';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->text('review_note')->nullable()->comment('審核備註');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('review_note');
        });
    }
}
