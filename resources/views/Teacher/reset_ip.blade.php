@extends('layouts.app')

@section('sidebar')
    @parent
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>

@endsection


@section('content')
    <h1 align="center" class="layui-container">解锁ip</h1>
    <div class="layui-form-item">
        <label class="layui-form-label">学/工号</label>
        <div class="layui-input-inline">
            <input type="text" name="num" required lay-verify="required" placeholder="学/工号" autocomplete="off"
                   class="layui-input" id="input1">
        </div>
        <div id="hint" class="layui-input-inline"></div>
        <button class="layui-btn" lay-submit lay-filter="formDemo" id="sub" >解锁</button>
    </div>

@endsection
@section('bottom')
    <script>
        $('#sub').click(function () {
            var num = $('#input1').val();
            $.ajax({
                type: "POST",
                url: "/reset_ip",
                data: "num=" + num + '&_token=' + '{{csrf_token()}}',
                success: function(msg){
                        if (msg == 0){
                            alert('成功');
                        }else {
                            alert('已解锁或不存在学号');
                        }

                }
            });
        })

    </script>
@endsection
