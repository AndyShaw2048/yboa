<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Rainwsy\Aliyunmail\Send\Single;
use Rainwsy\Aliyunmail\Auth;

class MailController extends Controller
{
    public static function sendMail($addr,$code)
    {
        $AccessKeyId = env('AccessKeyId');
        $AccessSecret = env('AccessSecret');
        Auth::config($AccessKeyId, $AccessSecret);

        $mail = new Single();
        $mail->setAccountName('admin@oa.xhsdyb.cn');
        $mail->setFromAlias('西华师大易班OA系统');
        $mail->setReplyToAddress('true');
        $mail->setAddressType('1');
        $mail->setToAddress($addr);
        $mail->setSubject('请假审核信息');
        $mail->setHtmlBody(view('email',['code'=>$code]));
        $mail->send();
    }
    
    public function toHtml()
    {
        $status = 0;
        $code = Route::input('code');
        $leave = Leave::where('code',$code)->firstOrFail();
        $diff =strtotime('now') - strtotime($leave['created_at']);
        if($diff > 86400){
            $status = 1;
        }
        if($leave['accept_opinion']){
            $status = 2;
        }
        return view('check',['status' => $status,'code' => $code,'leave' => $leave]);
    }

    public function store(Request $request)
    {
        $leave = Leave::where('code',$request->code)->firstOrFail();
        if($request->check == 1)
            $leave->accept_opinion = '批准';
        else
            $leave->accept_opinion = '驳回';
        $leave->accept_time = date("Y-m-d H:i:s",time());
        $leave->save();
        return Redirect::back();
    }
}