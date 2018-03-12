<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\ApplyItemDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\SendMegController;

class ApiController extends Controller
{
    public static function getInventoryList()
    {
        $msg = Inventory::all();
        $array = null;
        foreach($msg as $key => $item)
        {
            $array[$key]['id'] = $item['id'];
            $array[$key]['text'] = $item['name'];
        }
        return $array;
    }

    public static function testSendMsg(){
        $r = SendMegController::sendMsg('876100','15808310571','计算机学院','1002320');
        if($r->result)
            var_dump('fail');
        dd($r->result);
    }

    public function testReg(){
        return view('register',['isRegister' => false,'username' => '肖勇','errors' => []]);
    }

}
