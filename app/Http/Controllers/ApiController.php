<?php

namespace App\Http\Controllers;

use App\Inventory;
use Illuminate\Http\Request;

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
}
