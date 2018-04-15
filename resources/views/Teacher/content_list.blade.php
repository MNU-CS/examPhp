@extends('layouts.app')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h2 align="center" style="color: blue;">竞赛列表</h2>
    <div align="center">{!! $res->links() !!}</div>
    <table class="layui-table" lay-skin="line"  lay-even>
        <tr>
            <td>下载</td>
            <td>编号</td>
            <td>考试名称</td>
            <td>开始时间</td>
            <td>结束时间</td>
            <td>是否公开</td>
            <td>状态</td>
            <td>编辑</td>
            <td>操作人</td>
            <td>操作时间</td>
        </tr>
        @foreach($res as $k => $value)
            <tr>
                <td><a href="{{url('download?id=' . $value->id . '&title=' . $value->title)}}">
                        <img src="{{asset('image/download.png')}}" alt="下载">
                    </a></td>
                <td>{{$value->id}}</td>
                <td>{{$value->title}}</td>
                <td>{{$value->start_time}}</td>
                <td>{{$value->end_time}}</td>
                <td>
                    <a href="{{url('update_open?id=' . $value->id . '&open=' . $value->open)}}" >
                        @if($value->open == 1)
                            <div style="color: green;">开放</div>
                        @else
                            <div style="color: red;">内部</div>
                        @endif
                    </a>
                </td>

                <td>
                    <a href="{{url('update_cstatus?id=' . $value->id . '&status=' . $value->status)}}" >
                        @if($value->status == 1)
                            <div style="color: green;">有效</div>
                        @else
                            <div style="color: red;">无效</div>
                        @endif
                    </a>
                </td>
                <td><a href="{{url('update_content?id=' . $value->id)}}">
                        <img src="{{'image/edit.png'}}" alt="编辑" style="height: 15%">
                    </a></td>
                <td>{{$value->update_at}}</td>

                <td>{{$value->update_time}}</td>
            </tr>
        @endforeach
    </table>

@endsection
