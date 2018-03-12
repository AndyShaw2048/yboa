<?php

namespace App\Http\Controllers;

use Qcloud\Sms\SmsSingleSender;

class SendMegController extends Controller
{

    //指定模板发送

    public static function sendMsg($tpl_id,$tel,$name,$list_id){
        $templateId = $tpl_id;
        $smsSign = '西华师大易班';
        $ssender = new SmsSingleSender(env('MSG_APPID'), env('MSG_APPKEY'));
        $params = [$name,$list_id];
        $result = $ssender->sendWithParam("86", $tel, $templateId,
                                          $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
        $rsp = json_decode($result);
        return $rsp;
}
}
