<?php

use App\Constants\TradeTypesConstants;
use App\Models\TradeType;
use Illuminate\Database\Migrations\Migration;

class UpdateTradeTypeTableStep1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        TradeType::query()->firstOrCreate([
            'name' => TradeTypesConstants::FILL_ORDER
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
