@extends('layouts.app')

@section('sidebar')
    @parent
@endsection


@section('content')
    <h1 align="center" class="layui-container">更改密码</h1>
    <form action="{{url('change_pwd')}}" method="post" class="layui-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label">学/工号</label>
            <div class="layui-input-inline">
                <input type="text" name="num" required  lay-verify="required" placeholder="请输入学/工号"
                       autocomplete="off" class="layui-input" @if(session('num') != null) value="{{session('num')}}" @endif>
            </div>
            @if(session('msg') != null)
                <label class="layui-form-label">{{session('msg')}}</label>

            @endif
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="passwd" required  lay-verify="required" placeholder="请输入密码"
                       autocomplete="off" class="layui-input">
            </div>
            @if(session('msg') != null)
                <label class="layui-form-label">{{session('msg')}}</label>

            @endif
        </div>
        <input type="hidden" name="update_at" value="{{session('teacher')}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">提交</button>
            </div>
        </div>
    </form>

@endsection
