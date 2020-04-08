<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/13
 * Time: 15:52
 */

namespace app\common\validate;

use think\Validate;

/**
 * 商家员工验证器
 * Class AppUser
 * @package app\common\validate
 */
class SellerStaff extends Validate
{
    //定义验证规则
    protected $rule = [
        'mobile|手机号' => 'require|checkMobilePattern',
        'password|密码' => 'require|max:20',
    ];

    //定义验证提示
    protected $message = [
        'mobile.require' => '手机号不能为空',
        'mobile.checkMobilePattern' => '手机号不正确',
        'password.require' => '密码不能为空',
        'password.max' => '登录密码不符合要求,请重新填写',
    ];

    //定义验证场景
    protected $scene = [
        // 登录前验证
        'check' => ['mobile' => 'require|checkMobilePattern'],
        //登录验证
        'login' => ['mobile' => 'require|checkMobilePattern','password'],
    ];

    /**
     * 验证手机号码格式
     * @param $value
     * @return bool
     */
    public function checkMobilePattern($value, $rule, $data)
    {
        $preg = '/^(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/';
        return preg_match($preg, $value) ? true : "手机号码格式填写错误,请重新填写";
    }
}
