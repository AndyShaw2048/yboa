<link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
<script src="{{ admin_asset ("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<div class="container" style="width: 350px;">
    @if($status == 1)
        <div style="position: absolute;top: 40%;text-align: center">
            该网页链接已过期，请登录oa系统进行处理。
        </div>
    @elseif($status == 2)
        <div style="position: relative;top: 300px;text-align: center">
            该假条已被处理。
        </div>
    @else
    <form class="form-block text-center" action="/mail/leave" method="post">
        <div class="form-group" style="margin-top: 10px">
            {{csrf_field()}}
            <input name="code" type="text" hidden value="{{$code}}">
            <input name="check" value="2" hidden>
            <div class="input-group" style="margin-top: 160px">
                <div class="input-group-addon">姓名</div>
                <input type="text" class="form-control" value="{{$leave['apply_name']}}" readonly>
            </div>

            <div class="input-group" style="margin-top: 10px">
                <div class="input-group-addon">学院</div>
                <input type="text" class="form-control" value="{{$leave['apply_college']}}" readonly>
            </div>

            <div class="input-group" style="margin-top: 10px">
                <div class="input-group-addon">年级</div>
                <input type="text" class="form-control" value="{{$leave['apply_grade']}}" readonly>
            </div>

            <div class="input-group" style="margin-top: 10px">
                <div class="input-group-addon">理由</div>
                <input type="" class="form-control" value="{{$leave['apply_reason']}}" readonly>
            </div>

            <div class="input-group" style="margin-top: 10px">
                <div class="input-group-addon">时间</div>
                <textarea type="text" class="form-control" wrap="hard" cols="2" readonly>{{$leave['apply_startTime']}}&#10;{{$leave['apply_endTime']}}</textarea>
            </div>
            <div style="margin-top: 10px">
                <button class="btn btn-danger submit1" type="submit" onclick="sub(0);">驳回</button>
                <button style="margin-left: 50px" class="btn btn-success submit1" type="submit" onclick="sub(1);">批准</button>
            </div>
        </div>
    </form>
    @endif
</div>

<script>
    function sub($c){
        var check = document.getElementsByName('check');
        $(check).val($c);
    }

</script>
