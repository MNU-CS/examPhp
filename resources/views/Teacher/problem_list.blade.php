@extends('layouts.app')


{{--左一半--}}
@section('sidebar')
    @parent
@endsection
{{--又一半--}}
@section('content')
    <h2 align="center" style="color: blue;">Problem List</h2>
    <div align="center">{!! $res->links() !!}</div>
<table class="layui-table" lay-skin="line"  lay-even>
    <tr>
        <td colspan="6"><a href="javascript:void(0)" onclick="cc();">选中添加考试</a></td>
    </tr>
    <tr>
        <td>编号</td>
        <td>题目名称</td>
        <td>更改时间</td>
        <td>删除</td>
        <td>编辑</td>
        <td>操作人</td>
    </tr>
    @foreach($res as $k => $value)
        <tr>
            <td><input type="checkbox" name="pid[]" value="{{$value->id}}">{{$value->id}}</td>
            <td>{{$value->title}}</td>
            <td>{{$value->update_time}}</td>
            <td>
                @if(session('del') == 1)
                    <a href="{{url('delete_pc?id=' . $value->id . '&flag=1')}}" onclick="confirm('确定删除吗?')">
                        <img src="{{asset('image/delete.png')}}" alt="删除" style="height: 70%">
                    </a>
                @endif
            </td>
            <td ><a href="{{url('update_problem?id=' . $value->id)}}" >
                    <img src="{{('image/edit.png')}}" alt="编辑" style="height: 15%">
                </a></td>
            <td>{{$value->update_at}}</td>
        </tr>
    @endforeach
</table>

@endsection
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>

<script>
    function cc() {
        var chenked=$("input[type='checkbox']:checked").val([]);
//        console.log(chenked);
        var names = "";
        for(var i=0;i<chenked.length;i++){
            names += chenked[i].value +",";
        }
        names = names.substr(0, names.length - 1);
        window.location.href = 'add_content?pid=' + names;
    };
</script>
