<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 10:45
 */

namespace app\common\service;

use think\Cache;
use think\helper\Hash;
use app\common\util\Token;
use app\common\lib\Alidayu;
use app\api\controller\v1\Vcode;
use app\common\logic\User as UserLogic;

/***
 * 用户相关业务类
 * Class User
 * @package app\common\service
 */
class User extends Base
{
    /**
     * 用户登录注册找回密码逻辑类
     * @var UserLogic|null
     */
    protected $userLogic = null;

    /**
     * 构造方法
     * UserLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userLogic = new UserLogic();
    }

    /***
     * 获取验证码
     * 判断登录类型 登录类型设定,1用户名密码登录,2短信密码登录,3用户注册,4找回密码
     * @param $params
     */
    public function getMessageCode($params)
    {
        try {
            $validateRegister = validate('User');
            if (!$validateRegister->check($params, [], 'getCode')) {
                $this->message = $validateRegister->getError();
                return;
            }
            $isRegister = $this->userLogic->isRegister($params['mobile']);
            if ($params['login_type'] == 3) {  //类型为3,注册
                if (!empty($isRegister)) {
                    list($this->status, $this->message) = [0, '当前手机号已存在,请直接登录'];
                    return;
                }
            } else {
                if (empty($isRegister)) {
                    list($this->status, $this->message) = [0, '当前手机号还未注册,请先注册'];
                    return;
                }
            }
            cache($params['mobile'] . '_mobile', $params['mobile'], config('app.message_expire_time')); //缓存60s,1分钟
            $nowTime = cache($params['mobile'] . '_nowTime') ? cache($params['mobile'] . '_nowTime') : 0;
            $expTime = cache($params['mobile'] . '_expTime') ? cache($params['mobile'] . '_expTime') : 0;
            $countNum = cache($params['mobile'] . '_count') ? cache($params['mobile'] . '_count') : 1;
            if (!empty($nowTime) && !empty($expTime)) {
                if ($nowTime < $expTime) {
                    if ($countNum <= 3) {
                        $this->setMessageCode($params['mobile'], $countNum);
                        return;
                    } else {
                        $verCode = (new Vcode())->getVerify(); //返回图片验证码
                        list($this->status, $this->message, $this->data) = [0, '频繁获取验证码', $verCode];
                        return;
                    }
                } else {
                    $this->setMessageCode($params['mobile'], $countNum);
                    return;
                }
            } else {
                $this->setMessageCode($params['mobile'], $countNum);
                return;
            }
        } catch (\Exception $e) {
            list($this->status, $this->message) = [0, '获取失败'];
        }
    }

    /***
     * 获取图形验证码
     */
    public function getVerify()
    {
        try{
            $verCode = (new Vcode())->getVerify(); //返回图片验证码
            list($this->status, $this->message, $this->data) = [1, '获取成功', $verCode];
            return;
        }catch(\Exception $e){
            list($this->status, $this->message) = [0, '获取失败'];
            return;
        }
    }
    /***
     * 校验验证码
     */
    public function checkVCode($params)
    {
        try {
            $verCode = (new Vcode())->checkVCode($params);
            if ($verCode) {
                $mobile = $params['mobile'];
                cache($mobile . '_code', NULL);
                cache($mobile . '_count', NULL);
                cache($mobile . '_nowTime', NULL);
                cache($mobile . '_expTime', NULL);//清除缓存
                list($this->status, $this->message) = [1, '验证码验证通过'];
                return;
            } else {
                $verCode = (new Vcode())->getVerify(); //返回图片验证码
                list($this->status, $this->message, $this->data) = [0, '请输入正确的验证码', $verCode];
                return;
            }
        }catch(\Exception $e){
            list($this->status, $this->message) = [0, '校验失败'];
            return;
        }
    }

    /***
     * 生成短信验证码
     * @param $mobile |电话
     * @param $countNum |5分钟内获取验证码的次数
     */
    public function setMessageCode($mobile, $countNum)
    {
        try{
            //发送验证码
            $registerCode = mt_rand(100000, 999999);//随机六位验证码
            if (empty($registerCode)) {
                $registerCode = mt_rand(100000, 999999);
            }
            cache($mobile . '_code', $registerCode, config('app.message_expire_time'));
            cache($mobile . '_count', $countNum + 1, config('app.message_expire_time'));
            cache($mobile . '_nowTime', time(), config('app.message_expire_time'));
            cache($mobile . '_expTime', strtotime("+5 minute"), config('app.message_expire_time'));
            list($this->status, $this->message, $this->data) = [1, '获取成功', $registerCode];
            return;
        }catch(\Exception $e){
            list($this->status, $this->message) = [0, '获取失败'];
            return;
        }
    }

    /***
     * 注册协议
     */
    public function registerAgreement()
    {
        try {
            $registerAgreement = $this->userLogic->registerAgreement();
            if(empty($registerAgreement)){
                list($this->status, $this->message) = [1, '获取成功'];
                return;
            }
            list($this->status, $this->message, $this->data) = [1, '获取成功', $registerAgreement['content']];
            return;
        } catch (\Exception $e) {
            list($this->status, $this->message) = [0, '注册协议获取失败'];
            return;
        }
    }

    /***
     * 用户注册
     */
    public function register($params)
    {
        try {
            if ($params['mobile'] !== cache($params['mobile'] . '_mobile')) {
                list($this->status, $this->message) = [0, '注册失败,请输入获取验证码时的电话号码'];
                return;
            }

            if ($params['msgCode'] !== cache($params['mobile'] . '_code')) {
                list($this->status, $this->message) = [0, '注册失败,请输入正确的验证码'];
                return;
            }

            $validateRegister = validate('User');
            if (!$validateRegister->check($params, [], 'register')) {
                $this->message = $validateRegister->getError();
                return;
            }

            $params['loginpwd'] = Hash::make($params['loginpwd']);
            $params['nickname'] = $params['mobile'];
            $userRegister = $this->userLogic->register($params);
            if ($userRegister) {
                cache($params['mobile'] . '_code', NULL);
                list($this->status, $this->message) = [1, '注册成功'];
                return;
            } else {
                list($this->status, $this->message) = [0, '注册失败'];
                return;
            }
        } catch (\Exception $e) {
            list($this->status, $this->message) = [0, '注册失败'];
            return;
        }

    }

    /***
     * 用户登录
     * @param $params
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($params)
    {
        try {
            //判断登录类型 登录类型设定,1用户名密码登录,2短信密码登录
            if ($params['login_type'] == 1) {
                $validateRegister = validate('User');
                if (!$validateRegister->check($params, [], 'register')) {
                    $this->message = $validateRegister->getError();
                    return;
                }
                $isLogin = $this->userLogic->isRegister($params['mobile']);
                if (empty($isLogin)) {
                    list($this->status, $this->message) = [0, '当前手机号还未注册,请先注册'];
                    return;
                }
                if ($isLogin['is_disable'] == 1) {
                    list($this->status, $this->message) = [0, '当前用户已被禁用,请联系客服'];
                    return;
                }
                if (!Hash::check((string)$params['loginpwd'], $isLogin['loginpwd'])) {
                    list($this->status, $this->message) = [0, '请输入正确的账号密码'];
                    return;
                }
                $this->loginReturn($isLogin);
            } elseif ($params['login_type'] == 2) {//短信登录
                if ($params['mobile'] !== cache($params['mobile'] . '_mobile')) {
                    list($this->status, $this->message) = [0, '登录失败,请输入获取验证码时的电话号码'];
                    return;
                }
                if ($params['msgCode'] !== cache($params['mobile'] . '_code')) {
                    list($this->status, $this->message) = [0, '请输入正确的6位验证码'];
                    return;
                }
                $isLogin = $this->userLogic->isRegister($params['mobile']);
                cache($params['mobile'] . '_code', NULL);
                $this->loginReturn($isLogin);
            }
        } catch (\Exception $e) {
            list($this->status, $this->message) = [0, '登录失败'];
            return;
        }
    }

    /***
     * 登录成功之后的返回
     * @param $isLogin
     */
    public function loginReturn($isLogin)
    {
        // 使用JWT生成TOKEN
        $userToken = Token::makeToken($isLogin['id']);
        // 用户头像
        $isLogin['head_img'] = $isLogin['head_img'] ? config('token.web_site_domain') . get_file_path($isLogin['head_img']) : config('public_static_path').'admin/img/none.png';
        list($this->status, $this->message, $this->data) = [1, '登录成功', [
            'id'        => $isLogin['id'],
            'sex'       => $isLogin['sex'],
            'mobile'    => $isLogin['mobile'],
            'head_img'  => $isLogin['head_img'],
            'nickname'  => $isLogin['nickname'],
            'token'     => $userToken
        ]];
        return;
    }

    /***
     * 找回密码
     */
    public function resetPwd($params)
    {
        try {
            //验证密码
            $validateRegister = validate('User');
            if (!$validateRegister->check($params, [], 'retrievePwd')) {
                $this->message = $validateRegister->getError();
                return;
            }
            if ($params['mobile'] !== cache($params['mobile'] . '_mobile')) {
                list($this->status, $this->message) = [0, '找回失败,请输入获取验证码时的电话号码'];
                return;
            }
            if ($params['msgCode'] !== cache($params['mobile'] . '_code')) {
                list($this->status, $this->message) = [0, '找回失败,验证码输入错误'];
                return;
            }
            if ($params['loginpwd'] !== $params['loginpwd_confirm']) {
                list($this->status, $this->message) = [0, '两次密码输入不一致'];
                return;
            }
            $mobile = $params['mobile'];
            $password = Hash::make($params['loginpwd']);
            $resetPwd = $this->userLogic->resetPwd($mobile, $password);
            if ($resetPwd) {
                cache($params['mobile'] . '_code', NULL);
                list($this->status, $this->message) = [1, '密码找回成功'];
                return;
            } else {
                list($this->status, $this->message) = [0, '密码找回失败'];
                return;
            }
        } catch (\Exception $e) {
            list($this->status, $this->message) = [0, '找回失败'];
            return;
        }
    }

    /***
     * 查询是否设置支付密码
     */
    public function isPayPwd($params)
    {
        try{
            $isPayPwd = $this->userLogic->isPayPwd($params);
            if($isPayPwd['is_paypwd'] == 0){
                $isSet = '1';//未设置
            } elseif($isPayPwd['is_paypwd'] == 1){
                $isSet = '2';//已设置
            }
            list($this->status, $this->message,$this->data) = [1, '查询成功',$isSet];
            return;
        }catch(\Exception $e){
            list($this->status, $this->message) = [0, '查询失败'];
            return;
        }
    }
    /***
     * 设置支付密码
     */
    public function setPayPwd($params)
    {
        try{
            $validate = validate('PayPwd');
            if(!$validate->check($params,[],'setPayPwd')){
                list($this->status,$this->message) = [0,$validate->getError()];
                return;
            }
            $params['pay_pwd'] = Hash::make($params['pay_pwd']);//加密
            $setPayPwd = $this->userLogic->setPayPwd($params);
            if($setPayPwd){
                $status = 1;
                $msg = '设置成功';
            } else {
                $status = 0;
                $msg = '设置失败';
            }
            list($this->status, $this->message) = [$status,$msg];
            return;
        }catch(\Exception $e){
            list($this->status, $this->message) = [0, '设置失败'];
            return;
        }
    }
    /***
     * 重置支付密码
     */
    public function resetPayPwd($params)
    {
        try{
            //查询原密码
            //$queryOldPayPwd = $this->userLogic->queryOldPayPwd($params);
            if ($params['msgCode'] !== cache($params['mobile'] . '_code')) {
                list($this->status, $this->message) = [0, '修改失败,验证码输入错误'];
                return;
            }
            $validate = validate('PayPwd');
            if(!$validate->check($params,[],'setPayPwd')){
                list($this->status,$this->message) = [0,$validate->getError()];
                return;
            }
            //if (Hash::check((string)$params['pay_pwd'], $queryOldPayPwd['paypwd'])) {
            //    list($this->status, $this->message) = [0, '当前输入密码不能同于原密码,请重新填写'];
            //    return;
            //}
            $params['pay_pwd'] = Hash::make($params['pay_pwd']);//加密
            $resetPayPwd = $this->userLogic->changePayPwd($params);
            if($resetPayPwd){
                //如果更新成功,判断缓存是否存在,,存在则清空限制条件
                cache($params['mobile'] . '_code', NULL);
                cache($params['mobile'] . '_nowPayTime', NULL);
                cache($params['mobile'] . '_expPayTime', NULL);
                cache($params['mobile'] . '_errPayPwd', NULL);
                $status = 1;
                $msg = '修改成功';
            } else {
                $status = 0;
                $msg = '修改失败';
            }
            list($this->status, $this->message) = [$status, $msg];
            return;
        }catch(\Exception $e){
            list($this->status, $this->message) = [0, '修改失败'];
            return;
        }
    }
}