<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_id')->comment('学号');
            $table->unsignedInteger('content_id')->comment('考试id');
            $table->unique(['num_id','content_id']);
            $table->foreign('num_id')->references('num')->on('student');
            $table->foreign('content_id')->references('id')->on('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group');
    }
}
