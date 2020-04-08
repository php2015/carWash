<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/28
 * Time: 19:27
 */

namespace app\common\validate;


use think\Validate;

/***
 * 支付密码验证器
 * Class PayPwd
 * @package app\common\validate
 */
class PayPwd extends Validate
{
    protected $rule = [
        'pay_pwd|支付密码'   => 'require|numbers',
    ];
    //定义验证提示
    protected $message = [
        'pay_pwd.require'   => '请输入支付密码',
    ];
    //定义验证场景
    protected $scene = [
        'setPayPwd' => ['pay_pwd'],
    ];
    public function numbers($value, $rule, $data)
    {
        $preg = '/^\d{6}$/';
        return preg_match($preg, $value) ? true : '支付密码必须输入6位数字';
    }
}