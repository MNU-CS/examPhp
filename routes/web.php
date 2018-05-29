<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});
//登录
Route::match(['post','get'],'login','Student\IndexController@login');
//学生查看考试列表
Route::get('content','Student\IndexController@content');
//后台管理员页面呢
Route::get('manage','Teacher\AdminController@admin');
//题目列表
Route::get('problem_list','Teacher\ProblemController@problem_list');
//添加题目
Route::match(['post','get'],'add_problem','Teacher\ProblemController@add_problem');
//更改题目
Route::match(['post','get'],'update_problem','Teacher\ProblemController@update_problem');
//更改题目状态
Route::get('update_status','Teacher\ProblemController@update_status');
//添加用户
Route::match(['post','get'],'add_user','Teacher\UserController@add_user');
//考试列表
Route::get('content_list','Teacher\ContentController@content_list');
//添加考试
Route::match(['post','get'],'add_content','Teacher\ContentController@add_content');
//更改考试
Route::match(['post','get'],'update_content','Teacher\ContentController@update_content');
//更改考试状态
Route::get('update_cstatus','Teacher\ContentController@update_cstatus');
//更改内部-》公共
Route::get('update_open','Teacher\ContentController@update_open');
//管理员列表
Route::get('teacher_list','Teacher\UserController@teacher_list');
//更改老师状态（是否有效）
Route::get('del_user','Teacher\UserController@del_user');
//更改用户密码
Route::match(['post','get'],'change_pwd','Teacher\UserController@change_pwd');
//授予考试权限
Route::match(['post','get'],'grant_power','Teacher\UserController@grant_power');
//查看考试题目
Route::get('online_problem','Student\IndexController@online_problem');
//查看题目详细信息
Route::match(['post','get'],'detail_problem','Student\IndexController@detail_problem');
//修改个人信息
Route::match(['post','get'],'user_information','Student\IndexController@user_information');
//退出
Route::get('logout','Student\IndexController@logout');
//下载
Route::get('download','Teacher\ContentController@download');
//批量添加
Route::match(['post','get'],'add_batch','Teacher\UserController@add_batch');
//管理员更改个人信息
Route::match(['post','get'],'admin_information','Teacher\AdminController@admin_information');
//查看提交记录
Route::get('show_submit','Teacher\ContentController@show_submit');
//查看代码
Route::get('show_code','Teacher\ContentController@show_code');
//删除题目或比赛
Route::get('delete_pc','Teacher\ContentController@delete_pc');
