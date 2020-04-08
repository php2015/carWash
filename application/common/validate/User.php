<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 10:55
 */

namespace app\common\validate;


use think\Validate;

/***
 * 用户模型验证器
 * Class User
 * @package app\common\validate
 */
class User extends Validate
{
    //定义验证规则
    protected $rule = [
        'mobile|电话号码'   => 'require|phone',
        'loginpwd|登录密码' => 'require|pwd',

    ];
    //定义验证提示
    protected $message = [
        'mobile.require'   => '请输入11位手机号码',
        'loginpwd.require' => '请输入6-20位字母/数字组合,字母区分大小写',
    ];

    //定义验证场景
    protected $scene = [
        'getCode' => ['mobile'],//获取短信验证码
        'register'=> ['mobile','loginpwd'],//注册
        'retrievePwd'=>['loginpwd'],//找回密码
    ];

    //验证电话号码
    public function phone($value, $rule, $data)
    {
        $preg = '/^13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57][0-9]{8}$/';
        return preg_match($preg, $value) ? true : '手机号码填写错误,请重新填写';
    }
    //验证密码
    public function pwd($value, $rule, $data)
    {
        $preg = '/^[0-9a-z]{6,20}$/';
        return preg_match($preg,$value) ? true : '请输入6-20位字母/数字组合,字母区分大小写的密码';
    }
}