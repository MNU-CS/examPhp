@extends('layouts.stu')


@section('head')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection
@section('content')


    <div align="center">{!! $res->links() !!}</div>
    <table class="layui-table" lay-skin="line"  lay-even align="center" style="width: 80%;">
        <tr>
            <td width="5%">状态</td>
            <td width="60%">考试名称</td>
            <td width="15%">开始时间</td>
            <td width="15%">结束时间</td>
            <td width="8%">是否公开</td>
        </tr>
        @foreach($res as $k => $value)
                <tr>
                    @if(date('Y-m-d H:i:s') >= $value->start_time && date('Y-m-d H:i:s') <= $value->end_time)
                        <td style="color: red">running</td>
                    @elseif(date('Y-m-d H:i:s') < $value->start_time)
                        <td style="color: green">waiting</td>
                    @else
                        <td style="color: black">ended</td>
                    @endif
                    <td class="layui-table-link" >
                        <a style="color: #01AAED" href="{{url('online_problem?id=' . $value->id)}}">
                            {{$value->title}}
                        </a>
                    </td>
                    <td>{{$value->start_time}}</td>
                    <td>{{$value->end_time}}</td>
                    @if($value->open == 1)
                    <td style="color:green">公开</td>
                    @else
                    <td style="color:red">内部</td>
                    @endif
                </tr>
        @endforeach
    </table>

@endsection