<html>

<head>
    <title>牡丹江师范学院</title>
    {{--        <link rel="stylesheet" href="{{asset('css/normalize.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/page.css')}}">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}">
    {{--        <link rel="stylesheet" href="{{asset('css/app.css')}}">--}}
    {{--        <script src="{{asset('js/app.js')}}"></script>--}}
    <script src="{{asset('laydate/laydate.js')}}"></script>
    <script src="{{asset('layui/layui.js')}}"></script>
    <script>layui.use(['jquery','form','table','element','upload','code','layedit'], function(){
            var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
            var table = layui.table;
            var element = layui.element;
            var upload = layui.upload;
            var code = layui.code;
            var edit = layui.code;
            table.render();
            form.render();
        });
    </script>

    @yield('head')
</head>
<body background="{{asset('image/background.jpg')}}">
@section('sidebar')
    <ul class="layui-nav " style="height: 8%;">
        <li class="layui-nav-item">
            <a href="{{url('content')}}">考试列表</a>
        </li>
        <li class="layui-nav-item">
            <a href="">{{session('name')}}</a>
            <dl class="layui-nav-child">
                <dd><a href="{{url('user_information')}}">修改信息</a></dd>
                <dd><a href="{{url('logout')}}">退出</a></dd>
            </dl>
        </li>
    </ul>
@show
<div class="container"  style="height: 92%;" align="center">
    @yield('content')
</div>

@yield('bottom')

</body>

</html>