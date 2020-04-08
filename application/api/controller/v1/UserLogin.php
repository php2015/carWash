<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 10:24
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\User as UserService;
class UserLogin extends Base
{
    /**
     * 用户相关业务类
     * @var UserService|null
     */
    protected $userService = null;

    /***
     * 重写构造函数
     * UserLogin constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->userService = new UserService();
    }

    /***
     * 获取短信验证码
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getMessageCode()
    {
        $params = [
            'mobile'=>input('mobile','','trim'),
            'login_type'=>input('login_type/d',0),
        ];
        $this->userService->getMessageCode($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }

    /***
     * 注册协议
     */
    public function registerAgreement()
    {
        $this->userService->registerAgreement();
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }
    /***
     * 用户注册
     */
    public function register()
    {
        $params = [
            'mobile'=>input('mobile','','trim'),
            'loginpwd'=>input('loginpwd','','trim'),
            'msgCode'=>input('msgCode/d',0),//短信验证码
            'login_type'=>input('login_type/d',0),//登录类型3用户注册
        ];
        $this->userService->register($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }

    /***
     * 用户登录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login()
    {
        $params = [
            'mobile'=>input('mobile','','trim'),//电话
            'loginpwd'=>input('loginpwd','','trim'),//密码
            'msgCode'=>input('msgCode/d',0),//短信验证码
            'login_type'=>input('login_type/d',0),//登录类型1用户名密码登录,2短信密码登录
        ];
        $this->userService->login($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }

    /***
     * 找回密码
     */
    public function resetPwd()
    {
        $params = [
            'mobile'=>input('mobile','','trim'),
            'msgCode'=>input('msgCode/d',0),
            'loginpwd'=>input('password','','trim'),
            'loginpwd_confirm'=>input('password_confirm','','trim'),
        ];
        $this->userService->resetPwd($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }

    /***
     * 获取图形验证码
     */
    public function getVerify()
    {
        $this->userService->getVerify();
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }

    /***
     * 校验验证码
     */
    public function checkVCode()
    {
        $params = [
            'sid'=>input('sid','','trim'),
            'code'=>input('code','','trim'),
            'mobile'=>input('mobile','','trim'),
        ];
        $this->userService->checkVCode($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }
}