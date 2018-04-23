<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->text('descripe')->comment('题目描述');
            $table->text('input')->nullable()->comment('样例输入');
            $table->text('output')->nullable()->comment('样例输出');
            $table->dateTime('update_time')->comment('更改时间');
            $table->string('update_at')->comment('更改人');
            $table->text('hint')->nullable()->comment('提示');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problem');
    }
}
