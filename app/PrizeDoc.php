<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrizeDoc extends Model
{
    protected $table = 'prizedocs';

    public static function getStatus($id)
    {
        $isEdited = PrizeDoc::where('id',$id)
                              ->select('accept_opinion')
                              ->get();
        return $isEdited[0]->accept_opinion;
    }

    public static function getSumStatus($id)
    {
        $isEdited = PrizeDoc::where('id',$id)
                            ->select('accept_sum_opinion')
                            ->get();
        return $isEdited[0]->accept_sum_opinion;
    }
}
