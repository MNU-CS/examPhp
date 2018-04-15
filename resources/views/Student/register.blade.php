<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>学生登录页</title>
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap3/css/bootstrap-theme.css')}}">
</head>

<body>
<header>
</header>
<section>
    <div class="form" style="width: 100%;height: 100%;opacity: 1" >
        <form class="w7" action="{{url('register)}}" method="post">
            <ul>
                <li>
                    <h2>用户注册</h2>
                </li>
                <li>
                    <input type="text" placeholder="请输入学号">
                    <input type="text" placeholder="请输入手机号">
                    <input type="text" placeholder="请输入姓名">
                    <input type="password" placeholder="请输入密码">
                    <button type="submit">注册</button>
                </li>
            </ul>
        </form>
    </div>
</section>
<footer>
</footer>
</body>

</html>
