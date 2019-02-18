<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('information_notify_id');
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('information_notify_id', 'fk_user_information_information_notify_id')
                ->references('id')->on('information_notify')->onDelete('cascade');
            $table->foreign('user_id', 'fk_user_information_user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->unique(['information_notify_id', 'user_id']);
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
        Schema::dropIfExists('user_information');
        DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
