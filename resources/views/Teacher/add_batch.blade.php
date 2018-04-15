@extends('layouts.app')

@section('sidebar')
    @parent

@endsection


@section('content')
    <h1 align="center" class="layui-container">批量添加用户</h1>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="test1">
            <i class="layui-icon">&#xe67c;</i>上传excel
            </button>
        </div>
    </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo" id="sub">立即提交</button>
            </div>
        </div>

@endsection
@section('bottom')
    <script>
        //执行实例
        layui.use('upload',function () {
            var upload = layui.upload;
            upload.render({
                elem: '#test1' //绑定元素
                ,url: '/add_batch' //上传接口
                ,accept: 'file'
                ,method: 'post'
                ,auto: false
                ,bindAction: '#sub'
                ,data: {'_token' : '{{ csrf_token() }}'}
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
