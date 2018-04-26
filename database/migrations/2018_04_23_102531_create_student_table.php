<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('student', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('num')->unique()->comment('学号／工号');
        $table->string('passwd')->comment('密码');
        $table->string('name')->comment('姓名');
        $table->dateTime('register_time')->comment('创建时间');
        $table->string('class')->comment('班级');
        $table->integer('role')->comment('角色');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
