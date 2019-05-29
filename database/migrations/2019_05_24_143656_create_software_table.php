<?php

use App\Constants\Common\StatusConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('標題');
            $table->string('description')->comment('描述');
            $table->string('download_link')->nullable()->comment('下載連結');
            $table->string('qrcode_link')->nullable()->comment('qrcode連結');
            $table->enum('status', StatusConstants::enum())->comment('狀態');
            $table->unsignedInteger('software_category_id')->comment('軟件分類id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            //foreign
            $table->foreign('software_category_id', 'fk_software_software_category_id')
                ->references('id')->on('software_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('software');
    }
}
