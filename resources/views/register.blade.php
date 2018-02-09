<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <link rel="stylesheet" href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/css-register-banner/style.css" type="text/css" />
</head>

<body>
<div id="container">
    <p></p>
    <p><a href="#" style="text-decoration: none;">Hello</a></p>
</div>

{{--已经注册成功显示如下页面--}}
@if($isRegister)
    <?php
    header("Refresh:3;url=/admin");
    ?>
    <div class="container text-center">
        <p style="font-size: 24px">亲爱的{{$username}}，您已成功认证，即将前往登录页面！</p>
        <a href="/logout">取消授权</a>
    </div>
@endif



{{--没有注册显示如下页面--}}
@if(!$isRegister)
    <div class="container">
        <div style="width: 600px;margin: 0 auto;">
            {{--填写后提示错误信息--}}
            @if(count($errors)>0)
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert">
                        &times;
                    </a>
                    {{$errors->all()[0]}}
                </div>
            @endif

            <form class="form-horizontal" action="/register" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">*用户名</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" id="username" placeholder="请填入11位手机号码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">*密码</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="password" placeholder="请输入6-20位的密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="col-sm-2 control-label">*确认密码</label>
                    <div class="col-sm-10">
                        <input type="password" name="password_confirmation" class="form-control" id="confirm_password" placeholder="请再次输入密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">*联系电话</label>
                    <div class="col-sm-10">
                        <input type="text" name="telephone" class="form-control" id="phone" placeholder="请输入有效联系电话">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">电子邮箱</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" id="email" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="qq" class="col-sm-2 control-label">QQ号码</label>
                    <div class="col-sm-10">
                        <input type="text" name="qq" class="form-control" id="qq" placeholder="">
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">注册</button>
                        <a class="btn btn-default" href="/logout">更换账号</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
</body>

</html>