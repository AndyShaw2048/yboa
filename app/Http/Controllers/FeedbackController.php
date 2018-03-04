<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        if(isset($_COOKIE['timeout'])){
            return Redirect()->back()->withErrors(['tips' => 3]);
        }
        $content = $request->input('content');
        $user_id = session('user_id');
        if(session('user_id') == 'UnLoginUser')
            $user_id = 0;
        $feedback = new Feedback();
        $feedback->user = $user_id;
        $feedback->content = $content;
        $r = $feedback->save();
        if($r)
            $tips = 1;
        else
            $tips = 2;
        setcookie('timeout','true',time()+300);
        return Redirect()->back()->withErrors(['tips' => $tips]);
    }
}
