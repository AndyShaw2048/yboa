<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    protected $table = 'item_details';

    public static function updateAfter($itemid,$after)
    {
        $msg = ItemDetail::where('id',$itemid)
                           ->update(['after' => $after]);
        return $msg;
    }

    public static function updateBefore($itemid,$before)
    {
        $msg = ItemDetail::where('id',$itemid)
                         ->update(['before' => $before]);
        return $msg;
    }
}
