<?php

namespace App\Http\Controllers;

use Encore\Admin\Facades\Admin;

use \Yunpian\Sdk\YunpianClient;

class YunpianController extends Controller
{
    public function index()
    {
        $clnt = YunpianClient::create(env('YP_APIKEY'));
        $r = $clnt->user()->get()->data();
//        dd($r);

        $user  = Admin::user();
        $hasPer = Admin::user()->isRole('minister');
        $hasPer ? dd('true'):dd('false');
    }
}
