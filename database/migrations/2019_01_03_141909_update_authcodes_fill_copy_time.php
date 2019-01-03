<?php

use App\Constants\TradeTypesConstants;
use App\Models\Authcode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Migrations\Migration;

class UpdateAuthcodesFillCopyTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        \DB::transaction(function () {
            Authcode::query()->whereHas('tradeType', function (Builder $builder) {
                $builder->where('name', TradeTypesConstants::FILL_ORDER);
            })->update(['created_at' => \DB::raw('pay_end_time')]);
        });
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
