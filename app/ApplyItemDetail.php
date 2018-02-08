<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ApplyItemDetail extends Model
{
    protected $table='apply_item_detail';

    public function ApplyItem()
    {
        return $this->belongsTo(ApplyItem::class);
    }


    //从ApplyItem存id到applyitemdetail
    public static function postApplyItemStatus($id,$status = 1)
    {
        $ins = new ApplyItemDetail();
        $ins->apply_item_id = $id;
        $ins->status = ($id.'|'.$status);
        $ins->save();
    }

    //获取当前订单的最新审核情况
    public static function getNewestStatus($id,$status)
    {
        if($status==1)
            return null;
        $column = 'accept_'.($status-1).'_opn';
        $r = ApplyItemDetail::where('apply_item_id',$id)->select($column)->get();
        foreach($r as $value)
            return $value->$column;
    }

    //获取当前订单的最新审核时间
    public static function getNewestTime($id,$status)
    {
        if($status==1)
            return null;
        $column = 'accept_'.($status-1).'_time';
        $r = ApplyItemDetail::where('apply_item_id',$id)->select($column)->get();
        foreach($r as $value)
            return $value->$column;
    }

    //根据ItemID获取当前订单的Status
    public static function getStatus($id)
    {
        $r = ApplyItemDetail::where('apply_item_id',$id)
                              ->select('status')
                              ->get();
        $array  = null;
        foreach($r as $value)
            $array = $value->status;
        $array = explode('|',$array);
        return $array;
    }

    //根据ItemID获取当前订单的Status
    public static function getStatusOnId($id)
    {
        $r = ApplyItemDetail::where('id',$id)
                            ->select('status')
                            ->get();
        $array  = null;
        foreach($r as $value)
            $array = $value->status;
        $array = explode('|',$array);
        return $array;
    }

    //更新status
    public static function updateStatus($id,$string)
    {
        ApplyItemDetail::where('apply_item_id',$id)
                         ->update(['status' => $string]);
    }
}
