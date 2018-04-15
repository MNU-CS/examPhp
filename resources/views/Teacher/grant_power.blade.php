@extends('layouts.app')

@section('sidebar')
    @parent
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
@endsection


@section('content')
    <h1 align="center" class="layui-container">授予比赛权限</h1>
    <form action="{{url('grant_power')}}" method="post" class="layui-form" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        {{--<input type="file" name="file">--}}
        <div class="layui-form-item">
            <label class="layui-form-label">添加方式</label>
            <div class="layui-input-inline">
                <select name="type" lay-verify="required" id="sel">
                    <option value=""></option>
                    <option value="0" >单个</option>
                    <option value="1" >批量</option>
                </select>
            </div>


        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">学号</label>
            <div class="layui-input-inline">
                <input type="text" name="num"  placeholder="请输入学号"
                       autocomplete="off" class="layui-input">
            </div>
            <div id="test2">
                <button type="button" class="layui-btn" id="test1">
                    <i class="layui-icon">&#xe67c;</i>上传excel
                </button>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">考试编号</label>
            <div class="layui-input-inline">
                <input type="text" name="content_id" required  lay-verify="required" placeholder="请输入考试编号"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <input type="hidden" name="update_at" value="{{session('teacher')}}">
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo"  id="subm" >立即提交</button>
            </div>
        </div>
    </form>

@endsection
@section('bottom')
    <script>
        //执行实例
        layui.use('upload',function () {
            var upload = layui.upload;
            var sel = $('#sel').val();
            console.log(sel);
            upload.render({
                elem: '#test1' //绑定元素
                ,url: '/grant_power' //上传接口
                ,accept: 'file'
                ,method: 'post'
                ,auto: false
                ,bindAction: '#subm'
                ,data: {'_token' : '{{ csrf_token() }}','':''}
                ,done: function(res){
                    alert(res.message);
                    //上传完毕回调
                }
                ,error: function(){
                    //请求异常回调
                }
            });
        });


    </script>
@endsection
