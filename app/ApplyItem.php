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

    //获取当前订单的状态
    public static function getStatus($id)
    {

    }
}
