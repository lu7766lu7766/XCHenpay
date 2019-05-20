<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_template', function (Blueprint $table) {
            $table->unsignedInteger('bank_id')->comment('銀行id');
            $table->unsignedInteger('template_id')->comment('範本id');
            //index
            $table->index(['bank_id', 'template_id'], 'idx_bank_template_bank_id_template_id');
            //foreign
            $table->foreign('bank_id', 'fk_bank_template_bank_id')
                ->references('id')->on('bank')->onDelete('cascade');
            $table->foreign('template_id', 'fk_bank_template_template_id')
                ->references('id')->on('template')->onDelete('cascade');
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
        Schema::dropIfExists('bank_template');
        DB::connection($this->getConnection())->statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
