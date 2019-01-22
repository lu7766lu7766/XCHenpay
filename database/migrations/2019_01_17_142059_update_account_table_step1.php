<?php

use App\Constants\Account\AccountStatusConstants;
use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAccountTableStep1 extends Migration
{
    private $table = 'accounts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->enum('status', AccountStatusConstants::enum())
                ->default(AccountStatusConstants::PENDING)
                ->comment('核卡狀態');
            $table->string('note')->nullable()->comment('備註');
        });
        Account::query()->update(['status' => AccountStatusConstants::APPROVAL]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('note');
        });
    }
}
