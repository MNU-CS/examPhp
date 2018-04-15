@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h2 align="center" style="color: blue;">提交列表</h2>
    <div align="center">{!! $res->links() !!}</div>
    <div align="center"><h2>共{{$all}}人提交</h2></div>
    <form action="{{url('show_submit')}}" method="get" class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">考试ID</label>
            <div class="layui-input-inline">
                <input type="text" name="content_id"  placeholder="请输入考试ID" value="{{$content_id}}"
                       autocomplete="off" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn" lay-submit lay-filter="formDemo">查询</button>
            </div>
        </div>

    </form>

    <table class="layui-table" lay-skin="line"  lay-even>
        <tr>
            <td>编号</td>
            <td>提交时间</td>
            <td>题目ID</td>
            <td>考试编号</td>
            <td>代码</td>
            <td>用户</td>
        </tr>
        @foreach($res as $k => $value)
            <tr>
                <td>{{$value->id}}</td>
                <td>{{$value->update_time}}</td>
                <td>{{$value->problem_id}}</td>
                <td>{{$value->content_id}}</td>
                <td ><a href="{{url('show_code?id=' . $value->id)}}" style="color: green;">查看</a></td>
                <td>{{$value->name}}</td>
            </tr>
        @endforeach
    </table>

@endsection
