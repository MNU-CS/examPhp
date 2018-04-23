<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_problem', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('content_id')->comment('考试id');
            $table->unsignedInteger('problem_id')->comment('题目id');
            $table->unique(['content_id','problem_id']);
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
        Schema::dropIfExists('online');
    }
}
