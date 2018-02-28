<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <title>西华师大易班OA系统|帮助文档</title>
    <link rel="shortcut icon" href="{{url('imgs/favicon.ico')}}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
    <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
    <script src=<?php echo url('js/js-help-nav/help.nav.js')?> >  </script>
    <LINK rel=stylesheet type=text/css href="css/css-help-nav/style.css">
    <link rel="stylesheet" href="css/css-help-nav/common.css">
    <link rel="stylesheet" href="message/message.css">
    <link rel="stylesheet" href="help-right-nav/css/style.css" type="text/css" />
    <script src="message/message.js"></script>
    <meta charset="UTF-8">
    <script type="text/javascript">
        var w,h,className;
        function getSrceenWH(){
            w = $(window).width();
            h = $(window).height();
            $('#dialogBg').width(w).height(h);
        }

        window.onresize = function(){
            getSrceenWH();
        }
        $(window).resize();

        $(function(){
            getSrceenWH();

            //显示弹框
            $(".box a").click(function(){
                className = $(this).attr('class');
                $('#dialogBg').fadeIn(300);
                $('#dialog').removeAttr('class').addClass('animated '+className+'').fadeIn();
            });

            //关闭弹窗
            $('.closeDialogBtn').click(function(){
                $('#dialogBg').fadeOut(300,function(){
                    $('#dialog').addClass('bounceOutUp').fadeOut();
                });
            });
        });


        //右侧客服悬浮窗口
        $(document).ready(function(){
            $(".side ul li").hover(function(){
                $(this).find(".sidebox").stop().animate({"width":"124px"},200).css({"opacity":"1","filter":"Alpha(opacity=100)","background":"#ae1c1c"})
            },function(){
                $(this).find(".sidebox").stop().animate({"width":"54px"},200).css({"opacity":"0.8","filter":"Alpha(opacity=80)","background":"#000"})
            });
        });
        //回到顶部
        function goTop(){
            $('html,body').animate({'scrollTop':0},600);
        }

    </script>

</head>


<body>
<div class="header" style="text-align: center;background-color: #3c3f50">
    <a href="/" title="单击返回主页"><img src="{{url('imgs/1.jpg')}}" alt="" height="300px"></a>
</div>
<div class="out-body">
    <div class="title">
        <div id="firstpane" class="menu_list">
            @foreach($head as $val)
                <p class="menu_head current">{{$val['title']}}</p>
                <div style="display:none" class=menu_body >
                @foreach($title[$val['id']] as $value)
                        <a href="#" class="description" id="{{$value['id']}}">{{$value['title']}}</a>
                @endforeach
                </div>
            @endforeach
                <div class="box">
                <a href="javascript:;" style="text-decoration: none" class="flipInX"><p class="menu_head">反馈建议</p></a>
                </div>
        </div>
    </div>
    <div id="content"><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><h3><b>登录的账号是什么？</b></h3><p>本系统使用的登录账号为易班账号，但我们的数据库没有易班的账号数据，需要您进行主动授权后，方可获取您易班账号的数据</p><p><span style="background-color: rgb(254, 233, 204); color: rgb(0, 0, 0);">若您为首次登录，请点击</span><a href="/register" target="_blank" style="background-color: rgb(254, 233, 204);">注册</a><span style="background-color: rgb(254, 233, 204); color: rgb(0, 0, 0);">按钮</span></p><h3><b>如何注册？</b></h3><p>第一步：进入登录页面，点击<span style="background-color: rgb(254, 233, 204);">注册</span>按钮</p><p>第二步：输入易班账号密码，登录后自动跳转到个人信息完善界面。若您没有输入易班账号密码就直接跳转，请点击更换账号&nbsp;&nbsp;</p><p>第三步：跳转至登录界面，输入您刚刚设置的账号密码即可登录成功&nbsp;&nbsp;<span style="background-color: rgb(254, 233, 204);"><br></span><br></p><p><span style="background-color: rgb(254, 233, 204);"><br></span></p><p><br></p></div>
</div>

{{--弹出窗口--}}
<div id="dialogBg"></div>
<div id="dialog" class="animated">
    {{--<img class="dialogIco" width="50" height="50" src="images/ico.png" alt="" />--}}
    <div class="dialogTop">
        <span style="position: relative;right: 130px;">反馈建议</span>
        <a href="javascript:;" class="closeDialogBtn"><i class="fa fa-close"></i></a>
    </div>
    <form action="feedback" method="post" id="editForm">
        {{csrf_field()}}
        <textarea class="feedback-content" name="content" autofocus maxlength="400" required style="resize: none;"></textarea>
        <button type="submit" class="btn btn-primary" style="margin-top: 4px">提交</button>
    </form>
</div>
<input id="tip" value="{{$errors}}" hidden>

<div style="clear: both"></div>
<div class="footer">Copyright © 2017-2018 西华师范大学易班工作中心 All Rights Reserved - 蜀ICP备18001356号-1</div>

<div class="side">

    <ul>

        <li><a href="//shang.qq.com/wpa/qunwpa?idkey=a5e43a6b33e0cf2fad54091dec3e1d2b8a71b5093b1a657844725e67cc0212cd" target="_blank"><div class="sidebox"><img src="help-right-nav/img/side_icon01.png">客服QQ群</div></a></li>

        <li><a href="tencent://message/?uin=570057644&Site=西华师大易班OA系统&Menu=yes" target="_blank"><div class="sidebox"><img src="help-right-nav/img/side_icon04.png">技术支持</div></a></li>

        <li><a href="//weibo.com/u/6380197769?refer_flag=1001030102_&is_hot=1" target="_blank"><div class="sidebox"><img src="help-right-nav/img/side_icon03.png">新浪微博</div></a></li>

        <li style="border:none;"><a href="javascript:goTop();" class="sidetop"><img src="help-right-nav/img/side_icon05.png"></a></li>

    </ul>

</div>


</body>
<script>
    var element = document.getElementById('tip');
    $tip = element.getAttribute('value');
    $tip = $tip.substring(9,10);
    console.log($tip);
    if($tip == '1'){
        $.message('感谢您的反馈');
    }
    if($tip == '2'){
        $.message({
            message:'反馈出错啦',
            type:'error'
        });
    }
</script>
</html>