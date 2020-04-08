<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/28
 * Time: 19:11
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\User as UserService;

/***
 * 用户支付密码相关接口
 * Class UserSetPayPwd
 * @package app\api\controller\v1
 */
class UserSetPayPwd extends Base
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
     * 是否设置支付密码
     */
    public function isPayPwd()
    {
        $params = [
            'user_id'=>$this->uid,
        ];
        $this->userService->isPayPwd($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }

    /***
     * 设置支付密码
     */
    public function setPayPwd()
    {
        $params = [
            'user_id'=>$this->uid,
            'pay_pwd'=>input('password','','trim'),
        ];
        $this->userService->setPayPwd($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }
    /***
     * 重置支付密码
     */
    public function resetPayPwd()
    {
        $params = [
            'user_id'=>$this->uid,
            'mobile' =>input('mobile','','trim'),
            'msgCode'=>input('msgCode/d',0),
            'pay_pwd'=>input('password','','trim'),
        ];
        $this->userService->resetPayPwd($params);
        list($this->status,$this->message,$this->data) = [
            $this->userService->status,
            $this->userService->message,
            $this->userService->data,
        ];
    }
}