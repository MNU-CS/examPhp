@extends('layouts.app')


{{--左一半--}}
@section('sidebar')
    @parent
@endsection
{{--又一半--}}
@section('content')
    <h2 align="center" style="color: blue;">用户列表</h2>
    <div align="center">{!! $res->links() !!}</div>
    <form action="{{url('teacher_list')}}" method="get">
    <div class="layui-form-item">
        <label class="layui-form-label">学/工号</label>
        <div class="layui-input-inline">
            <input type="text" name="num" required lay-verify="required" placeholder="学/工号" autocomplete="off"
                   class="layui-input" value="{{$num}}">
        </div>
        <button class="layui-btn" lay-submit lay-filter="formDemo" >查询</button>
    </div>
    </form>
    <table class="layui-table" lay-skin="line"  lay-even>
        <tr>
            <td>类型</td>
            <td>工号</td>
            <td>名称</td>
            <td>注册时间</td>
            <td>编辑</td>
            <td>删除</td>
        </tr>
        @foreach($res as $k => $value)
            <tr>
                <td>
                    @if($value->role == 1)
                        学生
                        @elseif($value->role == 2)
                        老师
                        @elseif($value->role == 3)
                        管理员
                    @endif
                </td>
                <td>{{$value->num}}</td>
                <td>{{$value->name}}</td>
                <td>{{$value->register_time}}</td>
                <td><a href="{{url('admin_information?id=' . $value->id)}}">
                        <img src="{{asset('image/edit.png')}}" alt="编辑" style="height: 16%">
                    </a>
                </td>
                <td>
                    <a href="{{url('del_user?id=' . $value->id)}}" onclick="confirm('确定删除吗?')" >
                        <img src="{{asset('image/delete.png')}}" alt="删除" style="height: 70%">
                    </a>
                </td>

            </tr>
        @endforeach
    </table>
@endsection
