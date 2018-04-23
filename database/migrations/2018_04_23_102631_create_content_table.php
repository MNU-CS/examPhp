<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->dateTime('start_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间');
            $table->tinyInteger('open')->comment('是否开放');
            $table->tinyInteger('status')->comment('是否有效');
            $table->string('update_at')->comment('更改人');
            $table->dateTime('update_time')->comment('更改时间');
            $table->text('news')->nullable()->comment('新闻');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content');
    }
}
