<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href='http://cdn.webfont.youziku.com/webfonts/nomal/114292/19673/5a7d2b5cf629dc0a507de5f0.css' rel='stylesheet' type='text/css' />
    <title>西华师大易班OA系统</title>
    <meta charset="UTF-8">

    <style>
        body {
            background-color: #f2f2f5;
            margin: 0px;
            /*overflow: hidden;*/
            font-family:arial;
            color:#fff;
        }
        h1{
            margin:0;
        }

        #canvas{
            width:100%;
            height:100%;
            overflow: hidden;
            position:absolute;
            top:0;
            left:0;
            background-color: #efeff2;
        }
        .canvas-wrap{
            position:relative;
        }
        div.canvas-content{
            position:relative;
            z-index:2000;
            color:#fff;
            text-align:center;
            padding-top:30px;
        }
        .title{
            margin-top: 180px;
            font-size: 58px;
            font-family:'jdzhonyuanjian101e1aa9b21be74';
        }
        .bottom{
            margin-top: 280px;
        }
    </style>
    <!--[if IE]>
    <script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>
    <section class="canvas-wrap">
        <div class="canvas-content container">
            <div class="title">西华师范大学易班OA系统</div>
            <span style="font-size: 24px">- 科技，改变生活 -</span>
            <div style="margin-top: 80px">
                <a href="/admin" class="btn btn-info">登录系统</a>
                <a href="#" class="btn btn-info" style="margin-left: 100px">预留位置</a>
            </div>
            <div class="bottom">Copyright © 2017-2018 西华师范大学易班工作中心 All Rights Reserved - 蜀ICP备18001356号-1</div>
        </div>

        <div id="canvas" class="gradient"></div>
    </section>



<!-- Main library -->
<script src="http://cdn.bootcss.com/three.js/r68/three.min.js"></script>
<!-- Helpers -->
<script src="js/js-index/projector.js"></script>
<script src="js/js-index/canvas-renderer.js"></script>
<!-- Visualitzation adjustments -->
<script src="js/js-index/3d-lines-animation.js"></script>
<script src="http://www.jq22.com/jquery/2.1.1/jquery.min.js"></script>
<script src="js/js-index/color.js"></script>
</body>
</html>