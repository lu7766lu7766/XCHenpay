<?php

use App\Constants\Common\StatusConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分類名稱');
            $table->enum('status', StatusConstants::enum())->comment('狀態');
            $table->tinyInteger('sort')->comment('排序');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('software_category');
    }
}
