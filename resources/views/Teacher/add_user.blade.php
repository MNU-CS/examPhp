@extends('layouts.app')

@section('sidebar')
    @parent
@endsection


@section('content')
    <h1 align="center" class="layui-container">添加用户</h1>
    <form action="{{url('add_user')}}" method="post" class="layui-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label">用户类型</label>
            <div class="layui-input-inline">
                <select name="type" lay-verify="required">
                    <option value=""></option>
                    <option value="1">学生</option>
                    <option value="2">老师</option>
                    @if(session('del') == 1)
                        <option value="3">管理员</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">学/工号</label>
            <div class="layui-input-inline">
                <input type="text" name="num" required  lay-verify="required" placeholder="请输入学/工号"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="passwd" required  lay-verify="required" placeholder="请输入密码"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="name" required  lay-verify="required" placeholder="请输入姓名"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">部门/班级</label>
            <div class="layui-input-inline">
                <input type="text" name="class" required  lay-verify="required" placeholder="请输入部门/班级"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <input type="hidden" name="update_at" value="{{session('teacher')}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection

