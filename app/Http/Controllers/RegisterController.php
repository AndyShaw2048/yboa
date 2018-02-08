<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterValidate;
use App\Register;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use Authorize;
use Illuminate\Support\Facades\Crypt;
use YBLANG;
use YBException;
use YBOpenApi;


class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //易班接入配置项
        $config = array(
            'AppID'     => '0fa5afb76289cf89',
            'AppSecret' => 'b4c1ea3cca60a4a1fa7d5e714fea2cda',
            'CallBack'  => 'http://oa.com/register',
        );

        $api = YBOpenApi::getInstance()->init($config['AppID'], $config['AppSecret'], $config['CallBack']);
        $au  = $api->getAuthorize();
        //网站接入获取access_token，未授权则跳转至授权页面
        $info = $au->getToken();
        if(!$info['status']) {
            die;
            echo $info['msg'];
        }
        //网站接入获取的token
        $token = $info['token'];
        $api->bind($token);
        $result = $api->request('user/me');

        //获取userid
        $yiban_id = $result['info']['yb_userid'];

        $yb_username = $result['info']['yb_username'];
        //判断用户是否已注册
        $isRegister = false;
        $RegisterUser = Register::where('yiban_id',$yiban_id)->first();
        if($RegisterUser)
            $isRegister = true;

        //token存入session用于后续访问接口
        session(['token'=>$token]);
        return view('register',['isRegister'=>$isRegister,'username'=>$yb_username]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterValidate $request)
    {
        $config = array(
            'AppID'     => '0fa5afb76289cf89',  //此处填写你的appid
            'AppSecret' => 'b4c1ea3cca60a4a1fa7d5e714fea2cda',  //此处填写你的AppSecret
            'CallBack'  => 'http://oa.com/register',  //此处填写你的授权回调地址
        );
        $api = YBOpenApi::getInstance()->init($config['AppID'], $config['AppSecret'], $config['CallBack']);
        $token = session('token');
        $api->bind($token);
        $result = $api->request('user/me');

        //获取用户信息
        $yb_userid = $result['info']['yb_userid'];
        $yb_username = $result['info']['yb_username'];
        $yb_userhead = $result['info']['yb_userhead'];

        //信息存入数据库
        $RegisterUser = new Register();
        $RegisterUser->username = $request->username;
        $RegisterUser->password = bcrypt($request->password);
        $RegisterUser->yiban_id = $yb_userid;
        $RegisterUser->name = $yb_username;
        $RegisterUser->avatar = $yb_userhead;
        $RegisterUser->telephone = $request->telephone;
        $RegisterUser->email = $request->email;
        $RegisterUser->qq = $request->qq;
        $RegisterUser->save();

        //初始化用户角色
        $fresher = User::getUserid($yb_userid);
        Role::saveRoles($fresher);

        return view('register',['isRegister'=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function show(Register $register)
    {
        Crypt::encrypt();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function edit(Register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

    }


    //取消易班授权
    public function logout()
    {
        $config = array(
            'AppID'     => '0fa5afb76289cf89',
            'AppSecret' => 'b4c1ea3cca60a4a1fa7d5e714fea2cda',
            'CallBack'  => 'http://oa.com/register',
        );
        $api = YBOpenApi::getInstance()->init($config['AppID'], $config['AppSecret'], $config['CallBack']);
        $token = session('token');//网站接入获取的token
        $api->bind($token);
        $api->request('oauth/revoke_token', array('client_id'=>'0fa5afb76289cf89'),true);

        return redirect('/register');
    }
}
