<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src=<?php echo url('js/js-help-nav/help.nav.js')?> >  </script>
    <LINK rel=stylesheet type=text/css href="css/css-help-nav/style.css">
    <title>西华师大易班OA系统|帮助文档</title>
    <meta charset="UTF-8">
</head>
<body>
<div class="header">111</div>
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
        </div>
    </div>
    <div id="content">欢迎访问帮助文档</div>
</div>
<div style="clear: both"></div>
<div class="footer">Copyright © 2017-2018 西华师范大学易班工作中心 All Rights Reserved - 蜀ICP备18001356号-1</div>

</body>
</html>