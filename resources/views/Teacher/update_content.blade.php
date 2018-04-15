@extends('layouts.app')

@section('sidebar')
    @parent
@endsection


@section('content')
    <h1 align="center" class="layui-container">修改考试</h1>
    <form action="{{url('update_content')}}" method="post" class="layui-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{$res->id}}">
        <div class="layui-form-item">
            <label class="layui-form-label">考试名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" required  lay-verify="required" placeholder="请输入考试名称"
                       autocomplete="off" class="layui-input" value="{{$res->title}}">
            </div>
        </div>
        <div class="layui-form-item">

            <label class="layui-form-label">开始时间</label>
            <div class="layui-input-inline">
                <input type="text" id="start_time" required name="start_time" class="layui-input" value="{{$res->start_time}}">
            </div>

            <label class="layui-form-label">结束时间</label>
            <div class="layui-input-inline">
                <input type="text" id="end_time" required name="end_time" class="layui-input" value="{{$res->end_time}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否开放</label>
            <div class="layui-input-block">
                <input type="checkbox" name="open" lay-skin="switch" @if($res->open == 1) checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否有效</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" @if($res->status == 1) checked @endif>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">考试题目</label>
            <div class="layui-input-block">
                <input type="text" name="problem" required  lay-verify="required" placeholder="请输入题目编号，用,号分割"
                       autocomplete="off" class="layui-input" value="{{$problem}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新闻</label>
            <div class="layui-input-inline">
                <textarea name="news" id="" cols="40" rows="10">{{$res->news}}</textarea>
            </div>
            <label class="layui-form-label" style="margin-left: 5%">用户</label>
            <div class="layui-input-inline">
                <textarea name="users" id="" cols="40" rows="10">{{$user}}</textarea>
            </div>
        </div>

        <input type="hidden" name="update_at" value="{{session('teacher')}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </form>
@endsection
@section('bottom')
    <script>
        //执行一个laydate实例

        laydate.render({
            elem: '#start_time', //指定元素
            type: 'datetime'
        });
        laydate.render({
            elem: '#end_time',
            type: 'datetime'
        });
    </script>
@endsection
