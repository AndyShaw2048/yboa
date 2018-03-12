<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'admin_role_users';

    //为新增用户注册默认的角色：fresher
    public static function saveRoles($yiban_id){
        $fresher = new Role();
        $fresher->role_id = '6';
        $fresher->user_id = $yiban_id;
        $fresher->save();
    }

    //编辑用户角色
    public static function editRoles($userid,$role){
        $fresher = new Role();
        $result = $fresher::where('user_id',$userid)
                  ->update(['role_id' => $role]);
        return $result;
    }
}
