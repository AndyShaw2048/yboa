<?php

namespace App;

use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'admin_users';


    //取出当前用户的部门ID
    public static function department()
    {
        $department = User::where('id',Admin::user()->id)->get();
        foreach($department as $department_id)
            return ($department_id->department_id) ;
    }

    //取出当前用户的真实姓名
    public static function realname()
    {
        $department = User::where('id',Admin::user()->id)->get();
        foreach($department as $department_id)
            return ($department_id->name) ;
    }

    //取出当前用户的头像
    public static function avatar()
    {
        $department = User::where('id',Admin::user()->id)->get();
        foreach($department as $department_id){
//            if($department_id->avatar == null)
                return 'https://oa.xhsdyb.cn/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';
//            return ($department_id->avatar) ;
        }

    }

    //取出当前用户的身份
    public static function roles()
    {
        $roles = Admin::user()->roles;
        $result = null;
        foreach($roles as $role)
            $result = $result.' '.$role['name'];
        return $result;
    }

    //根据yiban_id取出当前用户的User_id
    public static function getUserid($yiban_id)
    {
        $INS = new User();
        $users = $INS::where('yiban_id',$yiban_id)->get();
        foreach($users as $user)
            return $user['id'];
    }


    //取出指定用户的真实姓名
    public static function getRealName($id)
    {
        $department = User::where('id',$id)->get();
        foreach($department as $department_id)
            return ($department_id->name) ;
    }

}
