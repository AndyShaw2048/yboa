<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jQuery添加背景动画效果插件</title>
    <link rel="stylesheet" type="text/css" href="css/css-register-bg/style/index.css">
    <link rel="stylesheet" type="text/css" href="css/css-register-bg/style/prism.css">
    <script src="https://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="css/css-register-bg/js/quietflow.min.js"></script>
    <script type="text/javascript" src="css/css-register-bg/js/index.js"></script>
    <script type="text/javascript" src="css/css-register-bg/js/prism.js"></script>

    <link rel="stylesheet" href="https://apps.bdimg.com/libs/bootstrap/3.3.4/fonts/glyphicons-halflings-regular.svg">
    <script src="https://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/css-register-banner/style.css" type="text/css" />
    <link rel="stylesheet" href="css/css-register-banner/style.css" type="text/css" />

</head>
<body>
<div id="container">
    <p></p>
    <p><a style="text-decoration: none;">Hello</a></p>
</div>
<div id="Wrapper">
    <div id="Box" class="text-center">
        {{--已经注册成功显示如下页面--}}
        @if($isRegister)
            <?php
            header("Refresh:3;url=/admin");
            ?>
            <div class="text-center">
                <p style="font-size: 18px">亲爱的{{$username}}，您已成功认证，即将前往登录页面！</p>
                <a href="/logout">取消授权</a>
            </div>
        @endif



        {{--没有注册显示如下页面--}}
        @if(!$isRegister)

                <div style="width: 410px;margin: 0 auto;">
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
                            <label for="username" class="col-sm-3 control-label">*用户名</label>
                            <div class="col-sm-9">
                                <input type="text" name="username" class="form-control" id="username" placeholder="请填入11位手机号码">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">*密码</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" id="password" placeholder="请输入6-20位的密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="col-sm-3 control-label">*确认密码</label>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation" class="form-control" id="confirm_password" placeholder="请再次输入密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-3 control-label">*联系电话</label>
                            <div class="col-sm-9">
                                <input type="text" name="telephone" class="form-control" id="phone" placeholder="请输入有效联系电话">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">电子邮箱</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="email" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qq" class="col-sm-3 control-label">QQ号码</label>
                            <div class="col-sm-9">
                                <input type="text" name="qq" class="form-control" id="qq" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="qq" class="col-sm-3 control-label">验证码</label>
                            <div class="col-sm-9">
                                {!! Geetest::render() !!}
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <div class="col-sm-offset-1 col-sm-10">
                                <button type="submit" class="btn btn-primary" style="margin: 0 50px 0 50px">注册</button>
                                <a class="btn btn-default" href="/logout">更换账号</a>
                            </div>
                        </div>
                    </form>
                </div>

        @endif



    </div>

</div>

</body>
</html>