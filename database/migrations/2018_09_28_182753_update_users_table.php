<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->enum('status', ['on', 'off'])->default('on')->after('password')->comment('状态');
            $table->enum('apply_status', ['on', 'off'])->default('on')->after('status')->comment('下发申请');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('status');
            $table->dropColumn('apply_status');
        });
    }
}
