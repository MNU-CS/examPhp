@extends('layouts.stu')
@section('head')
    @parent
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
@endsection

@section('sidebar')
    @parent
@endsection
@section('content')
    <div style="width: 40%;height: 40%;text-align: center;" align="center" >
        <br><br>
        <form action="{{url('user_information')}}" class="layui-form" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label">学号</label>
            <div class="layui-input-inline">
                <input type="text" name="num" required lay-verify="required" disabled
                       autocomplete="off" class="layui-input" value="{{$res->num}}">
            </div>
            <div class="layui-form-mid layui-word-aux">更改不了学号哦</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="passwd"   autocomplete="off" class="layui-input" >
            </div>
            <div class="layui-form-mid layui-word-aux">不填的话，不更改密码的哦</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="name" required lay-verify="required" value="{{$res->name}}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">班级</label>
            <div class="layui-input-inline">
                <input type="text" name="class" required lay-verify="required"
                       value="{{$res->class}}" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div style="width: 70%"><button class="layui-btn" style="width: 45%">提交</button></div>
        </div>
        </form>
    </div>

@endsection

