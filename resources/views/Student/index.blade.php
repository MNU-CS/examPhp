<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="{{asset('index/css/normalize.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('index/css/demo.css')}}" />
    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="{{asset('index/css/component.css')}}" />
    <!--[if IE]>
    <script src="{{asset('index/js/html5.js')}}"></script>

    <![endif]-->
</head>
<body>
<div class="container demo-1">
    <div class="content">
        <div id="large-header" class="large-header">
            <canvas id="demo-canvas"></canvas>
            <div class="logo_box">
                <h3 id="hint"></h3>
                <form action="#" name="f" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="input_outer">
                        <span class="u_user"></span>
                        <input name="username" id="username" class="text" style="color: #FFFFFF !important" type="text" placeholder="请输入账户">
                    </div>
                    <div class="input_outer">
                        <span class="us_uer"></span>
                        <input name="passwd" class="text" id="passwd" style="color: #FFFFFF !important; position:absolute; z-index:100;"value="" type="password" placeholder="请输入密码">
                    </div>
                    <div class="mb2"><a class="act-but submit" href="javascript:;" id="sub1" style="color: #FFFFFF">登录</a></div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /container -->
<script src="{{asset('index/js/TweenLite.min.js')}}"></script>
<script src="{{asset('index/js/EasePack.min.js')}}"></script>
<script src="{{asset('index/js/rAF.js')}}"></script>
<script src="{{asset('index/js/demo-1.js')}}"></script>
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script>
    $('#sub1').click(function () {
        var username = $('#username').val();
        var passwd = $('#passwd').val();
        if (username == '' || passwd == ''){
            alert('用户名和密码为必填项');
            return ;
        }
        $.ajax({
            type: "POST",
            url: "/login",
            data: "username=" + username + '&passwd=' + passwd,
            success: function(msg){
                if (msg == 1)
                    window.location.href = '/content';
                else{
                    $('#hint').html(msg);
                }
            }
        });
    });
</script>
</body>
</html>