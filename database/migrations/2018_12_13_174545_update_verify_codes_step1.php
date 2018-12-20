<?php

use App\Constants\Common\VerifyType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVerifyCodesStep1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('verify_codes', function (Blueprint $table) {
            $table->enum('type', VerifyType::enum())->default(VerifyType::ACCOUNT)->comment('驗證項目');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
