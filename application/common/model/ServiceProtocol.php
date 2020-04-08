<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 17:50
 */

namespace app\common\model;


use think\Model;

/***
 * 服务协议模型
 * Class ServiceProtocol
 * @package app\common\model
 * @property integer id             服务协议id
 * @property integer protocol_type  协议类别[1用户注册协议|2商家入驻申请协议|3帮助协议|4卡包使用说明|5关于我们]
 * @property string  content        协议内容
 * @property integer create_time    添加时间
 * @property integer update_time    更新时间
 * @property integer status         状态[0禁用|1启用]
 * @property integer is_delete      是否删除[0删除|1不删除]
 */
class ServiceProtocol extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 用户注册协议
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function registerAgreement()
    {
        $where['status'] = 1;
        $where['is_delete'] = 0;
        $where['protocol_type'] = 1;
        $field = 'content';
        return $this->field($field)->where($where)->find();
    }

    /***
     * 用户卡包使用说明
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function instructions()
    {
        $where['status'] = 1;
        $where['is_delete'] = 0;
        $where['protocol_type'] = 4;//卡包使用说明
        $field = 'id,content';
        return $this->field($field)->where($where)->find();
    }

    /**
     * 关于我们 
     */
    public function aboutUs()
    {
        $map['status'] = 1;
        $map['is_delete'] = ['neq',1];
        $map['protocol_type'] = 5;//关于 我们
        $result = $this->where($map)->order('id desc')->field("content")->find();
        return $result ? $result["content"] : "";
    }

    /**
     * 服务协议
     * @param type 用户服务协议,不传则默认为商家 服务协议
     */
    public function servAgreement($params)
    {
        $map['status'] = 1;
        $map['is_delete'] = ['neq',1];
        if(!empty($params['type'])){
            $map['protocol_type'] = 1;
        }else{
            $map['protocol_type'] = 2;
        }
        //查找启用未删除,降序id的 商家服务协议
        $result = $this->where($map)->order('id desc')->field("content")->find();
        return $result ? $result["content"] : "";
    }
}