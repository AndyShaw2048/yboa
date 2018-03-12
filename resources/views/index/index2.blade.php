<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>西华师大易班OA系统</title>
    <meta name="keywords" content="西华师大易班oa系统，西华师范大学易班oa系统，西华师范大学，西华师大，易班oa，西华师大易班">
    <meta name="description" content="西华师大易班OA系统旨在为易班工作站提供日常工作管理服务，由西华师范大学易班学生工作站技术部制作。">
    <link rel="shortcut icon" href="{{url('imgs/favicon.ico')}}">
    <link href='https://cdn.webfont.youziku.com/webfonts/nomal/114292/19673/5a7d2b5cf629dc0a507de5f0.css' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="{{url('index2/css/normalize.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('index2/css/component.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('index2/css/buttons.css')}}" />
    <script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
    <!--[if IE]>
    <script src="{{url('index2/js/html5.js')}}"></script>
    <![endif]-->
    <script type="text/javascript">
        $(window).load(function(){
            var header = document.getElementById('large-header');
            var loader = document.getElementById('loader');
            loader.hidden = true;
            header.removeAttribute('hidden');
        })
    </script>
    <style>
        .loader {
            position: absolute;
            top: 50%;
            left: 40%;
            margin-left: 10%;
            transform: translate3d(-50%, -50%, 0);
        }
        .dot {
            width: 24px;
            height: 24px;
            background: #3ac;
            border-radius: 100%;
            display: inline-block;
            animation: slide 1s infinite;
        }
        .dot:nth-child(1) {
            animation-delay: 0.1s;
            background: #32aacc;
        }
        .dot:nth-child(2) {
            animation-delay: 0.2s;
            background: #64aacc;
        }
        .dot:nth-child(3) {
            animation-delay: 0.3s;
            background: #96aacc;
        }
        .dot:nth-child(4) {
            animation-delay: 0.4s;
            background: #c8aacc;
        }
        .dot:nth-child(5) {
            animation-delay: 0.5s;
            background: #faaacc;
        }
        @-moz-keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }
        @-webkit-keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }
        @-o-keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }
        @keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
<div class="loader" id="loader">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>
<div class="container demo-1">
    <div class="content" style="height: 300px">
        <div id="large-header" class="large-header" hidden>
            <div class="main-title" style="font-family:'jdzhonyuanjian101e1aa9b21be74';">西华师范大学易班OA系统</div>
            <div class="subtitle">- 科技，改变生活 -</div>
            <div class="button-group">
                <a href="/admin" class="button button-glow button-rounded button-raised button-primary">登录系统</a>
                <a href="/help" class="button button-glow button-rounded button-raised button-primary" id="help">帮助文档</a>
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
<script>
    var s = window.screen.width;
    if(s > 460){
        var element = document.getElementById('help');
        element.style.marginLeft="160px";
    }
</script>
</body>
</html>