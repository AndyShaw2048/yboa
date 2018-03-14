<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';

    public static function check($request)
    {
        $leave = Leave::where('code',$request->code)->firstOrFail();
        if($request->check == 1)
            $leave->accept_opinion = '批准';
        else
            $leave->accept_opinion = '驳回';
        $leave->accept_time = date("Y-m-d H:i:s",time());
        $leave->save();
    }
}
