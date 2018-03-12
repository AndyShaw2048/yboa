<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'bail|required|digits:11',
            'password' => 'bail|required|alpha_dash|confirmed',
            'telephone' => 'bail|required|digits:11',
            'email' => 'nullable|email',
            'qq' => 'nullable|numeric',
        ];
    }

    /**
     * 获取被定义验证规则的错误消息.
     *
     * @return array
     * @translator laravelacademy.org
     */
    public function messages(){
        return [
            'username.required' => '用户名不能为空',
            'username.digits' => '用户名只能为11位数字',
            'password.confirmed' => '两次输入密码不匹配',
            'password.required' => '密码不能为空',
            'telephone.digits' => '电话号码输入有误',
            'email.email' => 'Email输入有误',
            'qq.numeric' => 'QQ输入有误'
        ];
    }
}
