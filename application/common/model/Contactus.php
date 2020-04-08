<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 11:35
 */

namespace app\common\model;

use think\Db;
use think\Model;

/**
 * 联系我们表模型
 * Class AppAdvert
 * @package app\common\model
 * @author ywdeng
 * @property integer id 联系我们id
 * @property string  name 客服名称
 * @property string  phone 联系电话
 * @property integer create_time 添加时间
 * @property integer status 状态 [0.禁用 1.启用]
 * @property integer is_delete 删除状态 [0.正常 1.删除]
 */
class Contactus extends Model
{
    /***
     * 随机查询已启用并且未删除的联系电话
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryContactPhone()
    {
        $where['status'] = 1;
        $where['is_delete'] = 0;
        return $this->where($where)->orderRaw('rand()')->limit(1)->select();
    }

    /**
     * 联系我们
     */
    public function contactUs()
    {
        //查找启用未删除,降序id
        $result = Db::name('contactus')->where("status = 1 and is_delete != 1")->order('id desc')->field("phone")->find();
        return $result ? $result["phone"] : "";
    }
}