<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationNotifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_notify', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->comment('信息類別ID');
            $table->string('subject')->comment('發佈主題');
            $table->text('content')->nullable()->comment('發佈內容');
            $table->timestamps();
            $table->foreign('category_id', 'fk_information_notify_category_id')
                ->references('id')->on('information_category')->onDelete('cascade');
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
        Schema::dropIfExists('information_notify');
        DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
