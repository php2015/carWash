<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 20:06
 */

namespace app\common\model;

use think\Db;
use think\Model;

/***
 * Class HomepageCate
 * @package app\common\model
 * @property integer  id          首页分类id
 * @property string   cardname    分类名称
 * @property integer  parent_id   类别父级id
 * @property string   path        类别路径
 * @property string   icon        类别图片
 * @property string   order_num   排序|默认值为100
 * @property integer  create_time 添加时间
 * @property integer  is_enable   是否启用[0禁用|1启用]
 * @property integer  is_delete   是否删除[0表示不删除|1表示删除]
 */
class HomepageCate extends Model
{
    /***
     * 获取营业项目
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBusiness()
    {
        $where['is_enable'] = 1;
        $where['is_delete'] = 0;
        $where['parent_id'] = 0;
        return $this->where($where)->order('order_num asc')->select();
    }

    /***
     * 新增服务时获取有子分类的营业项目
     */
    public function getDoBusiness($cateId)
    {
        return  Db::query("select * from (select id,catename,icon,order_num from dp_homepage_cate where id in ( select parent_id from `dp_homepage_cate` where is_enable = 1 and is_delete = 0 and parent_id !=0 ) order by order_num asc) hc where hc.id in ($cateId)");
    }
    /***
     * 获取营业项目的子类
     * @param $parentId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBusinessLevel($parentId)
    {
        $where['is_enable'] = 1;
        $where['is_delete'] = 0;
        $where['parent_id'] = $parentId;
        return $this->field('id,catename')->where($where)->order('order_num asc')->select();
    }
}