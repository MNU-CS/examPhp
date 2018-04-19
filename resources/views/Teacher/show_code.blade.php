@extends('layouts.app')
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
    @parent
@endsection

@section('content')

    <textarea id="editor" name="result" >{{$res->result}}</textarea>
    <script>

        var myTextarea = document.getElementById('editor');
        var CodeMirrorEditor = CodeMirror.fromTextArea(myTextarea, {
            mode: "text/x-c++src",
            lineNumbers: true,
            matchBrackets: true,
            theme: "monokai",
        });
        CodeMirrorEditor.setSize('100%','100%');
    </script>

@endsection
