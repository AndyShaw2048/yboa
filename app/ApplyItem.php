<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplyItem extends Model
{
    protected $table='apply_item';

    public function ApplyItemDetail()
    {
        return $this->hasOne(ApplyItemDetail::class);
    }

    //根据ID获取当前订单的Name、Tel
    public static function getInfo($id){
        $obj = ApplyItem::where('id',$id)
                          ->select('apply_id','apply_contact')
                          ->get();
        return $obj;
    }
}
