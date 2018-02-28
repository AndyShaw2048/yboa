<?php

namespace App\Http\Controllers;

use App\Help;
use Illuminate\Http\Request;
use EndaEditor;

class HelpController extends Controller
{

    //help首页
    public function index(){
        //获取主标题
        $obj_head = self::getTitle();
        $head = null;
        foreach($obj_head as $key => $value){
            $head[$key]['id'] = $value['id'];
            $head[$key]['title'] = $value['title'];
        }

        //获取副标题
        $title = null;
        foreach($head as $value){
            $obj_title = self::getTitle($value);
            foreach($obj_title as $key => $value){
                $parent_id = $value['parent_id'];
                $title[$parent_id][$key]['id'] = $value['id'];
                $title[$parent_id][$key]['title'] = $value['title'];
            }
        }

        return view('help',['head' => $head,'title' => $title]);
    }

    /* 获取title
     *
     * @parent_id 父ID
     * @return array
     */
    public static function getTitle($parent_id = 0)
    {
        $obj = Help::where('parent_id', $parent_id)->get();
        $title = null;
        foreach ($obj as $key => $value) {
            $title[$key]['id'] = $value['id'];
            $title[$key]['parent_id'] = $value['parent_id'];
            $title[$key]['title'] = $value['title'];
        }
        return $title;
    }


    //返回当前ID的问题描述
    public static function getContent(Request $request)
    {
        $id = $request->id;
        $obj = Help::where('id',$id)->get();
        foreach($obj as $value)
                $content = $value->content;
        return json_encode(EndaEditor::MarkDecode($content));
    }

    //图片上传
    public function upload(Request $request)
    {
        $photo = $request->file('photo');
        $path = $photo->store('/uploads/images','admin');
        return json_encode(['errno'=>0,'data'=>[url('/uploads/'.$path)]]);
    }
}
