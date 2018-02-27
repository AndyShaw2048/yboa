<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>html5 canvas首屏自适应背景动画循环效果代码</title>
    <link href='http://cdn.webfont.youziku.com/webfonts/nomal/114292/19673/5a7d2b5cf629dc0a507de5f0.css' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="{{url('index2/css/normalize.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('index2/css/component.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('index2/css/buttons.css')}}" />
    <!--[if IE]>
    <script src="{{url('index2/js/html5.js')}}"></script>
    <![endif]-->
</head>
<body>
<div class="container demo-1">
    <div class="content" style="height: 300px">
        <div id="large-header" class="large-header">
            <div class="main-title" style="font-family:'jdzhonyuanjian101e1aa9b21be74';">西华师范大学易班OA系统</div>
            <div class="subtitle">- 科技，改变生活 -</div>
            <div class="button-group">
                <a href="/admin" class="button button-glow button-rounded button-raised button-primary">登录系统</a>
                <a href="/help" class="button button-glow button-rounded button-raised button-primary" style="margin-left: 160px">帮助文档</a>
            </div>
            <div class="footer">Copyright © 2017-2018 西华师范大学易班工作中心 All Rights Reserved - 蜀ICP备18001356号-1</div>
            <canvas id="demo-canvas"></canvas>
        </div>
    </div>
</div><!-- /container -->
<script src="{{url('index2/js/TweenLite.min.js')}}"></script>
<script src="{{url('index2/js/EasePack.min.js')}}"></script>
<script src="{{url('index2/js/rAF.js')}}"></script>
<script src="{{url('index2/js/demo-1.js')}}"></script>
</body>
</html>