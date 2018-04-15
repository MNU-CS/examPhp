@extends('layouts.stu')
@section('head')
    @parent
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('codemirror/lib/codemirror.js')}}"></script>
    <script src="{{asset('codemirror/mode/clike/clike.js')}}"></script>
    <link rel="stylesheet" href="{{asset('codemirror/lib/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('codemirror/theme/monokai.css')}}">
    <style>
        body  {
        :font-family: Helvetica, 'Hiragino Sans GB', 'Microsoft Yahei', '微软雅黑', Arial, sans-serif;}
    </style>
@endsection

@section('sidebar')
    <ul class="layui-nav " style="height: 8%;">
        <li class="layui-nav-item">
            <a href="{{url('content')}}">考试列表</a>
        </li>
        <li class="layui-nav-item">
            <a href="{{url('online_problem?id=' . $content_id)}}">题目列表</a>
        </li>
        <li class="layui-nav-item">
            <a href="">{{session('name')}}</a>
            <dl class="layui-nav-child">
                <dd><a href="{{url('user_information')}}">修改信息</a></dd>
                <dd><a href="{{url('logout')}}">退出</a></dd>
            </dl>
        </li>
    </ul>
@endsection
@section('content')
    <div style="width: 100%;height: 100%;text-align: left;" align="center">
        <div style="float:left;width: 24%;margin-left: 1%;height: 100%;overflow-y:scroll" >
        <h1 style="color: #0000cc;text-align: center">{{$res->title}}</h1>
        <b>题目描述</b>
        <br>
            <blockquote class="layui-elem-quote">{{$res->descripe}}</blockquote>
            <br>
        <b>样例输入</b>
        <br><br>
            <blockquote class="layui-elem-quote">{{$res->input}}</blockquote>
        <b >样例输出</b>
        <br>
            <blockquote class="layui-elem-quote">{{$res->output}}</blockquote>
        <div >提示</div>
        <br>
            <blockquote class="layui-elem-quote">{{$res->hint}}</blockquote>
        <br><br>
        </div>
        <div style="float:left;width: 75%;height: 100%;background-color: #282819;overflow-y:scroll">
            <form action="{{url('detail_problem')}}" method="post" style="height: 100%">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="content_id" value="{{$content_id}}">
                <input type="hidden" name="id" value="{{$problem_id}}">
                <textarea id="editor" name="result" >{{$result}}</textarea>
                    <button class="layui-btn layui-btn-normal">提交</button>
            </form>
        </div>
    </div>

    <script>

        var myTextarea = document.getElementById('editor');
        var CodeMirrorEditor = CodeMirror.fromTextArea(myTextarea, {
            mode: "text/x-c++src",
            lineNumbers: true,
            matchBrackets: true,
            theme: "monokai",
        });
        CodeMirrorEditor.setSize('auto','95%');
    </script>

@endsection

