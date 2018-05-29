@extends('layouts.app')

@section('sidebar')
    @parent
@endsection


@section('content')
    <h1 align="center" class="layui-container">添加考试</h1>
    <form action="{{url('add_content')}}" method="post" class="layui-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label">考试名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" required  lay-verify="required" placeholder="请输入考试名称"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">

            <label class="layui-form-label">开始时间</label>
            <div class="layui-input-inline">
            <input type="text" id="start_time" required name="start_time" class="layui-input">
            </div>

            <label class="layui-form-label">结束时间</label>
            <div class="layui-input-inline">
            <input type="text" id="end_time" required name="end_time" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否开放</label>
            <div class="layui-input-block">
                <input type="checkbox" name="open" lay-skin="switch">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否有效</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">考试题目</label>
            <div class="layui-input-block">
                <input type="text" name="problem" required  lay-verify="required" placeholder="请输入题目编号，用,号分割"
                       autocomplete="off" class="layui-input" value="{{$res}}" id="problem">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新闻</label>
            <div class="layui-input-inline">
                <textarea name="news" id="" cols="40" rows="10"></textarea>
            </div>
            <label class="layui-form-label" style="margin-left: 5%">用户</label>
            <div class="layui-input-inline">
                <textarea name="users" id="" cols="40" rows="10"></textarea>
            </div>
        </div>
        <input type="hidden" name="update_at" value="{{session('teacher')}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo" onclick="return f();">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script>
        $('#problem').change(function () {
           var allproblem = $('#problem').val();
           console.log(allproblem);
           $.get('{{url("api/problem_confirm")}}',{problem:allproblem},function (data) {
               if (data == 0){
                   $('#problem').addClass("layui-bg-red");
               }
               else {
                   $('#problem').removeClass("layui-bg-red");
               }
           });
        });
    </script>
    <script>
        function f() {
            var bool = true;
            var allproblem = $('#problem').val();
            $.ajax({
                type : "get",
                url : "{{url("problem_confirm")}}",
                data : "problem=" + allproblem,
                async : false,
                success : function(data){
                    console.log(data);
                    if (data == 0){
                        bool = false;
                    }
                }
            });
            return bool;

        }
    </script>
@endsection
