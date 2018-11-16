<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAuthCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authcodes', function (Blueprint $table) {
            $table->index(['company_service_id'], 'authcodes_company_service_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authcodes', function (Blueprint $table) {
            $table->dropIndex('authcodes_company_service_id_index');
        });
    }
}
