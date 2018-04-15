<html>
<head>
    <link rel="stylesheet" href="{{asset('css/layui.css')}}">
</head>
    <style type="text/css">
        .body-bgcolor{ background-color: #fff}
        .showMsg{border: 1px solid #1e64c8; zoom:1; width:450px; height:172px;position:absolute;top:44%;left:50%;margin:-87px 0 0 -225px}
        .showMsg h5{margin:0px;background-image: url({{asset('images/message/msg.png')}});background-repeat: no-repeat; color:#fff; padding-left:35px; height:25px; line-height:26px;*line-height:28px; overflow:hidden; font-size:14px; text-align:left}
        .showMsg .content{ padding:46px 12px 73px 45px; font-size:14px; height:64px;display: inline-block;}
        .showMsg .bottom{ background:#e4ecf7; margin: 0 1px 1px 1px;line-height:26px; *line-height:30px; height:26px; text-align:center}
        .showMsg .ok,.showMsg .guery{background: url({{asset('images/message/msg_bg.png')}}) no-repeat 0px -560px;}
        .showMsg .guery{background-position: left -460px;}
    </style>

<body>
    <div class="panel-body">
        <div class="showMsg layui-bg-green" style="text-align:center" >
            <div class="content guery">{{ $data['message'] }}</div>
            <div class="bottom">
                @if($data['url'] == 'goback')

                @else
                    <a href="{{ $data['url']}}">如果您的浏览器没有自动跳转，请点击这里</a>
                @endif

                @if($data['ok'])
                    <script language="javascript">
                        {{--setTimeout(location = '{{ $data["url"]}}',"{{ $data['jumpTime'] }}");--}}
                        function jumpurl(){
                            location='{{$data['url']}}';
                        }
                        setTimeout('jumpurl()','{{$data["jumpTime"]}}');
                    </script>
                 @endif
            </div>
        </div>
    </div>
</body>
</html>