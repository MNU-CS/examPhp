@extends('layouts.stu')


@section('head')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection
@section('content')


    <h1 style="color: blue">{{$title->title}}</h1>
    <br><br>
    <marquee  behavior=scroll direction=left align=middle>
        <h2 style="color: red;">{{$title->news}}</h2>
    </marquee>
    <br><br>
    <label style="color: green">开始时间 ：{{$title->start_time}}</label>&nbsp;&nbsp;&nbsp;&nbsp;
    <label style="color: green">结束时间 ：{{$title->end_time}}</label>
    <br><br>

    <h3 style="color: orange"><?php echo '服务器当前时间   ' . date('Y-m-d H:i:s');?></h3>

    <table class="layui-table" lay-skin="line"  lay-even align="center" style="width: 80%;">
        <tr style="color: blue">
            <td width="5%">完成</td>
            <td width="70%">题目名称</td>
        </tr>
        @foreach($res as $k => $value)
            <tr>
                @if(in_array($value->id,$finish))
                    <td><img src="{{asset('image/right.png')}}" alt="是" style="height: 10%;"></td>
                @else
                    <td></td>
                @endif
                    <td ><a style="color: #01AAED" href="{{url('detail_problem?id=' . $value->id . '&content_id=' . $id)}}">
                        {{$value->title}}</a></td>
            </tr>
        @endforeach
    </table>
    <div align="center">{!! $res->links() !!}</div>

@endsection