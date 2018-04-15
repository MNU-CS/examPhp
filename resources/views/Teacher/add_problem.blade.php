@extends('layouts.app')

@section('sidebar')
    @parent
@endsection


@section('content')
    <h1 align="center" class="layui-container">添加题目</h1>
    <form action="{{url('add_problem')}}" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="layui-form-item">
            <label class="layui-form-label">题目名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" required  lay-verify="required" placeholder="请输入名称" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">题目描述</label>
        </div>
        <div id="descripe">
            <textarea name="descripe" style="display:none;"></textarea>
        </div>
        @include('markdown::encode',['editors'=>['descripe']])
        <div class="layui-form-item">
            <label class="layui-form-label">样例输入</label>
        </div>
        <div id="sample_input">
            <textarea name="sample_input" style="display:none;"></textarea>
        </div>
        @include('markdown::encode',['editors'=>['sample_input']])
        <div class="layui-form-item">
            <label class="layui-form-label">样例输出</label>
        </div>
        <div id="sample_output">
            <textarea name="sample_output" style="display:none;"></textarea>
        </div>
        @include('markdown::encode',['editors'=>['sample_output']])
        <div class="layui-form-item">
            <label class="layui-form-label">提示</label>
        </div>
        <div id="hint">
            <textarea name="hint" style="display:none;"></textarea>
        </div>
        @include('markdown::encode',['editors'=>['hint']])
        <input type="hidden" name="update_at" value="{{session('teacher')}}">
        <div align="center"><input type="submit" value="提交" class="layui-btn"></div>
    </form>
@endsection
