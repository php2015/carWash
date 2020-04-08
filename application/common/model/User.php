<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/21
 * Time: 19:15
 */

namespace app\common\model;


use think\Model;

/***
 * 用户模型
 * Class User
 * @package app\common\model
 * @property integer id       用户id
 * @property string  nickname 用户昵称
 * @property string  mobile   手机号码
 * @property integer head_img 头像
 * @property string  loginpwd 登录密码
 * @property string  paypwd   支付密码
 * @property string  sex      性别[0保密|1男|2女]
 * @property string  birthday 生日
 * @property string  create_time   注册时间
 * @property string  update_time   更新时间
 * @property integer is_paypwd  是否设置支付密码[0未设置|1已设置]
 * @property string  is_disable 是否禁用[0不禁用|1禁用]
 */
class User extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳
    /***
     * 获取用户信息
     * @param $userId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserInfo($userId)
    {
        $where['id'] = $userId;
        $field = 'id,nickname,mobile,head_img,loginpwd,paypwd,sex,birthday,create_time,update_time,is_disable';
        return $this->field($field)->where($where)->find();
    }

    /***
     * 验证手机号是否唯一
     * @param $mobile
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isRegister($mobile)
    {
        $where['mobile'] = $mobile;
        $field = 'id,nickname,mobile,head_img,loginpwd,sex,birthday,create_time,update_time,is_disable';
        return $this->field($field)->where($where)->find();
    }

    /***
     * 用户注册
     * @param $params
     * @return mixed
     */
    public function register($params)
    {
        $this->save($params);
        return $this->id;
    }

    /***
     * 找回密码
     * @param $mobile
     * @param $password
     * @return User
     */
    public function resetPwd($mobile,$password)
    {
        $where['mobile'] = $mobile;
        return $this->where($where)->update(['loginpwd'=>$password]);
    }

    /***
     * 查询是否设置了支付密码
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isPayPwd($params)
    {
        $where['id'] = $params['user_id'];
        $field = 'is_paypwd';
        return $this->field($field)->where($where)->find();
    }

    /***
     * 设置密码
     * @param $params
     * @return User
     */
    public function setPayPwd($params)
    {
        $where['id'] = $params['user_id'];
        $update = $params['pay_pwd'];
        return $this->where($where)->update(['paypwd'=>$update,'is_paypwd'=>1]);
    }

    /***
     * 查询重置支付密码的原密码
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryOldPayPwd($params)
    {
        $where['id'] = $params['user_id'];
        $field = 'id,paypwd,mobile';
        return $this->field($field)->where($where)->find();
    }

    /***
     * 修改支付密码
     * @param $params
     * @return User
     */
    public function changePayPwd($params)
    {
        $where['id'] = $params['user_id'];
        $update = $params['pay_pwd'];
        return $this->where($where)->update(['paypwd'=>$update]);
    }

    /**
     * 保存用户资料 
     * @param user_id 用户id
     * @param head_img 用户头像
     * @param nickname 用户昵称
     * @param sex 性别(0未知,1男,2女)
     * @param birthday 生日
     */
    public function saveUserInfo($params)
    {
        $map['id'] = $params['user_id'];
        return $this->where($map)->update($params);
    }


}