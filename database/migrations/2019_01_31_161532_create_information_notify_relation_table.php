<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationNotifyRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_notify_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('information_notify_id')->comment('訊息通知ID');
            $table->unsignedInteger('relate_id')->comment('關聯ID');
            $table->string('relate_type')->comment('關聯類型');
            $table->timestamps();
            //index
            $table->index(['relate_id', 'relate_type'], 'idx_relate_id_relate_type');
            //foreign
            $table->foreign('information_notify_id', 'fk_information_notify_relation_information_notify_id')
                ->references('id')->on('information_notify')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information_notify_relation');
    }
}
