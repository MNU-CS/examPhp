<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_id')->comment('学号');
            $table->unsignedInteger('content_id')->comment('考试id');
            $table->unsignedInteger('problem_id')->comment('题目id');
            $table->text('result')->comment('答案');
            $table->dateTime('create_time')->comment('创建时间');
            $table->text('update_time')->comment('更改时间');
            $table->unique(['num_id','content_id','problem_id']);
            $table->foreign('num_id')->references('num')->on('student');
            $table->foreign('content_id')->references('id')->on('content');
            $table->foreign('problem_id')->references('id')->on('problem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submit');
    }
}
