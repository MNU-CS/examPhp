<!DOCTYPE html>

<html>
<head>
    <title>
        教师登录页
    </title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{asset('image/logo_mdj.jpg')}}" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- 新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="{{asset('bootstrap3/css/bootstrap.min.css')}}">
    <!-- <script type="text/javascript" src="__PUBLIC__/js/jquery-1.4.1.min.js"></script> -->


    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    {{--<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>--}}

</head>
<body background="{{asset('image/tbg.jpg')}}">
<h1 class="text-center"><strong>牡丹江师范学院考试系统</strong>  </h1>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span4" align="center">
            <form class="form-signin" action={{url('admin')}} method="post" >
                <h2 class="form-signin-heading"><strong>登录</strong></h2>
                <h3 style="color: red;">{{session('k')}}</h3>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input  id="inputname" name="username" class="form-control" placeholder="学生学号" required autofocus style="width:240px;">
                <!-- <label for="inputPassword" class="sr-only">密码</label> -->
                <input type="password" id="password" name="passwd" class="form-control" placeholder="学生密码" required style="width:240px;">
                <!-- <div class="checkbox">
                  <label>
                    <input type="checkbox" value="remember-me"> 记住我
                  </label>
                </div> -->
                <button class="btn btn-lg btn-primary btn-block" type="submit" style="width:240px;">登录</button>




            </form>
        </div>

    </div>
</div>




</body>
</html>
