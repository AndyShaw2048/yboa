<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table='inventory';

    public static function getBefore($itemid)
    {
        $num = Inventory::where('id',$itemid)
                   ->select('stocks')
                   ->get();
        foreach ($num as $item) {
            $num = $item;
        }
        return $num['stocks'];
    }
    
    public static function updateStocks($itemid,$after)
    {
        $msg = Inventory::where('id',$itemid)
                          ->update(['stocks' => $after]);
        return $msg;
    }


}
