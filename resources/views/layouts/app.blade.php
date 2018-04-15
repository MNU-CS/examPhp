<html>

    <head>
    <title>牡丹江师范学院</title>
{{--        <link rel="stylesheet" href="{{asset('css/normalize.css')}}">--}}
        <link rel="stylesheet" href="{{asset('css/page.css')}}">
        <link rel="stylesheet" href="{{asset('css/layui.css')}}">
        <link rel="shortcut icon" href="{{asset('image/logo_mdj.jpg')}}" />
        {{--        <link rel="stylesheet" href="{{asset('css/app.css')}}">--}}
{{--        <script src="{{asset('js/app.js')}}"></script>--}}
        <script src="{{asset('laydate/laydate.js')}}"></script>
        <script src="{{asset('layui/layui.js')}}"></script>
        <script>layui.use(['jquery','form','table','element','upload'], function(){
                var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
                var table = layui.table;
                var element = layui.element;
                var upload = layui.upload;
                upload.render();
                table.render();
                form.render();
            });
        </script>

        @yield('head')
    </head>
    <body background="{{asset('image/background.jpg')}}">
    @section('sidebar')

        <div style="width: 15%;height: 100%; float: left;">
            <ol class="layui-nav layui-bg-cyan layui-nav-tree layui-nav-side">
                <li class="layui-nav-item layui-nav-itemed"><a href="{{url('content_list')}}">考试列表</a></li>
                <li class="layui-nav-item layui-nav-itemed"><a href="{{url('add_content')}}">添加考试</a></li>
                <li class="layui-nav-item layui-nav-itemed"><a href="{{url('problem_list')}}">题目列表</a></li>
                <li class="layui-nav-item layui-nav-itemed"><a href="{{url('add_problem')}}">添加题目</a></li>
                <li class="layui-nav-item layui-nav-itemed"><a href="{{url('show_submit')}}">答题记录</a></li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a href="javascript:;">用户管理</a>
                    <dl class="layui-nav-child ">
                        <dd><a href="{{url('add_user')}}">添加用户</a></dd>
                        <dd><a href="{{url('add_batch')}}">批量添加</a></dd>
                        {{--<dd><a href="{{url('grant_power')}}">授予比赛权限</a></dd>--}}
                        <dd><a href="{{url('teacher_list')}}">教师列表</a></dd>
                        <dd><a href="{{url('change_pwd')}}">更改密码</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-nav-itemed"><a href="{{url('admin_information')}}">个人信息</a></li>
                <li class="layui-nav-item layui-nav-itemed"><a href="{{url('logout')}}">退出</a></li>
            </ol>
        </div>
    @show
    <div class="container" style="width: 78%;height: 100%; float: left;">
        @yield('content')
    </div>

    @yield('bottom')

    </body>

</html>