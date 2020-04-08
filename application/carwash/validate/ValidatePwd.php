<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/13
 * Time: 19:26
 */

namespace app\carwash\validate;


class ValidatePwd extends Base
{
    //定义验证规则
    protected $rule = [
        'password'=>'require|confirm|checkPwd',
    ];

    //定义验证提示
    protected $message = [
        'password.require' =>'请输入密码',
        'password.confirm' =>'两次密码输入不一致',
    ];
    //验证密码
    public function checkPwd($value, $rule, $data)
    {
        $preg = '/^[_0-9a-z]{6,16}$/';
        return preg_match($preg, $value) ? true : "请输入6-16位数字字母下划线";
    }
}