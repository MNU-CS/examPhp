@extends('layouts.app')

@section('sidebar')
    @parent
@endsection


@section('content')
    <h2 align="center">编辑题目</h2>
    <form action="{{url('update_problem')}}" method="post">
        <input type="hidden" name="id" value="{{$res->id}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="div1">题目名称：<input type="text" name="title" value="{{$res->title}}"></div>
        <br>
        <div class="div1">题目描述:</div>
        <div id="descripe">
            <textarea name="descripe" style="display:none;">{{$res->descripe}}</textarea>
        </div>
        @include('markdown::encode',['editors'=>['descripe']])
        <div class="div1">样例输入</div>
        <div id="sample_input">
            <textarea name="sample_input" style="display:none;">{{$res->input}}</textarea>
        </div>
        @include('markdown::encode',['editors'=>['sample_input']])
        <div class="div1">样例输出</div>
        <div id="sample_output">
            <textarea name="sample_output" style="display:none;">{{$res->output}}</textarea>
        </div>
        @include('markdown::encode',['editors'=>['sample_output']])
        <div class="div1">提示</div>
        <div id="hint">
            <textarea name="hint" style="display:none;">{{$res->hint}}</textarea>
        </div>
        @include('markdown::encode',['editors'=>['hint']])
        <input type="hidden" name="update_at" value="{{session('teacher')}}">
        <div align="center"><input type="submit" value="提交" class="layui-btn"></div>
    </form>
@endsection
<style>
    .div1{
        margin-left: 20px;
    }
</style>