@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div style="width: 60%;height: 40%;text-align: center;" align="center" >
        <br><br>
        <form action="{{url('admin_information')}}" class="layui-form" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="num" value="{{$res->num}}">
            <input type="hidden" name="id" value="{{$res->id}}">
            <div class="layui-form-item">
                <label class="layui-form-label">工号</label>
                <div class="layui-input-inline">
                    <input type="text"  required lay-verify="required" disabled
                           autocomplete="off" class="layui-input" value="{{$res->num}}">
                </div>
                <div class="layui-form-mid layui-word-aux">更改不了工号哦</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                    <input type="password" name="passwd"   autocomplete="off" class="layui-input" placeholder="不填的话，不更改密码的哦">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" required lay-verify="required" value="{{$res->name}}" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">部门</label>
                <div class="layui-input-inline">
                    <input type="text" name="class" required lay-verify="required"
                           value="{{$res->class}}" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户类型</label>
                <div class="layui-input-inline">
                    <select name="type" lay-verify="required">
                        <option value=""></option>
                        <option value="1" @if($res->role == 1) selected @endif>学生</option>
                        <option value="2" @if($res->role == 2) selected @endif>老师</option>
                        @if(session('del') == 1)
                            <option value="3" @if($res->role == 3) selected @endif>管理员</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div style="width: 70%"><button class="layui-btn" style="width: 45%">提交</button></div>
            </div>
        </form>
    </div>
@endsection