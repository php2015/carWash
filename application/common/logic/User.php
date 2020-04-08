<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 10:47
 */

namespace app\common\logic;

use app\common\model\User as UserModel;
use app\common\model\ServiceProtocol as ServiceProtocolModel;
class User extends Base
{
    /**
     * 用户模型
     * @var UserModel|null
     */
    protected $userModel = null;

    /***
     * 服务协议模型
     * @var null
     */
    protected $serviceProtocolModel = null;

    /**
     * 构造方法
     * UserModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->serviceProtocolModel = new ServiceProtocolModel();
    }

    /***
     * 验证手机号是否存在
     * @param $mobile
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isRegister($mobile)
    {
        return $this->userModel->isRegister($mobile);
    }

    /***
     * 注册协议
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function registerAgreement()
    {
        return $this->serviceProtocolModel->registerAgreement();
    }

    /***
     * 用户注册
     * @param $params
     * @return mixed
     */
    public function register($params)
    {
        return $this->userModel->register($params);
    }

    /***
     * 找回密码
     * @param $mobile
     * @param $password
     * @return UserModel
     */
    public function resetPwd($mobile,$password)
    {
        return $this->userModel->resetPwd($mobile,$password);
    }

    /***
     * 查询是否设置了支付密码
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isPayPwd($params)
    {
        return $this->userModel->isPayPwd($params);
    }

    /***
     * 设置支付密码
     * @param $params
     * @return UserModel
     */
    public function setPayPwd($params)
    {
        return $this->userModel->setPayPwd($params);
    }

    /***
     * 查询重置支付密码的原密码
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryOldPayPwd($params)
    {
        return $this->userModel->queryOldPayPwd($params);
    }

    /***
     * 修改支付密码
     * @param $params
     * @return UserModel
     */
    public function changePayPwd($params)
    {
        return $this->userModel->changePayPwd($params);
    }
}