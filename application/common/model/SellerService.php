<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 16:06
 */

namespace app\common\model;

use think\Model;

/***
 * 商家服务模型
 * Class SellerService
 * @author ywdeng
 * @property integer id 商家服务id
 * @property integer seller_id 商家id
 * @property integer homepage_cate_parent_id 服务类别id|一级分类
 * @property integer homepage_cate_id 服务类别id|二级分类
 * @property string  servicename 服务名称
 * @property string  serviceprice 服务价格
 * @property string  remark 备注
 * @property integer create_time 添加时间
 * @property integer update_time 更新时间
 * @property integer is_startrights 是否开启权益卡 [0.禁用 1.启用]|默认1启用
 * @property integer is_timescard 是否支持次卡 [0.不支持 1.支持]|默认0不支持
 * @property integer is_release 状态 [0.禁用 1.启用]
 * @property integer is_delete 删除状态 [0.正常 1.删除]
 */
class SellerService extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳
    /***
     * 获取当前商家所有服务和一级分类名
     * @param $sellerId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllService($sellerId)
    {
        $where['ss.is_delete'] = 0;
        $where['ss.seller_id'] = $sellerId;
        $field = 'ss.id,ss.seller_id,ss.servicename,hc.catename,ss.serviceprice,ss.create_time,ss.is_release,ss.is_timescard,ss.remark';
        return $this
            ->alias('ss')
            ->field($field)
            ->join('dp_homepage_cate hc','ss.homepage_cate_parent_id = hc.id','left')
            ->where($where)
            ->select();
    }

    /***
     * 获取当前商家所有审核通过的服务
     * @param $sellerId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllInUseService($sellerId)
    {
        $where['is_delete'] = 0;
        $where['is_release'] = 1;  //0审核中,1审核通过,2驳回
        $where['seller_id'] = $sellerId;
        $field = 'id,seller_id,servicename,serviceprice,is_timescard,remark';
        return $this
            ->field($field)
            ->where($where)
            ->order('serviceprice desc')
            ->select();
    }
    /***
     * 查看服务详情
     * @param $id
     * @param $sellerId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catServiceDetail($id,$sellerId)
    {
        $where['ss.id'] = $id;
        $where['ss.seller_id'] = $sellerId;
        $field = 'ss.id,ss.seller_id,ss.servicename,hc.catename,ss.serviceprice,ss.create_time,ss.remark,ss.is_release';
        return $this
            ->alias('ss')
            ->field($field)
            ->join('dp_homepage_cate hc','ss.homepage_cate_parent_id = hc.id','left')
            ->where($where)
            ->find();
    }

    /***
     * 新增服务
     * @param $params
     * @return int
     */
    public function addService($params)
    {
        $this->save($params);
        return $this->id;
    }

    /***
     * 获取当前服务是否支持次卡
     * @param $sellerId
     * @param $serviceId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ServiceIsTimesCard($sellerId,$serviceId)
    {
        $where['seller_id'] = $sellerId;
        $where['id'] = $serviceId;
        return $this->field('id,seller_id,servicename,serviceprice,is_timescard,is_startrights')->where($where)->find();
    }

    /***
     * 用户端获取商家服务
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBizService($params)
    {
        $where['ss.is_delete'] = 0;
        $where['ss.is_release'] = 1;
        $where['ss.seller_id'] = $params['seller_id'];
        $field = 'ss.id,ss.servicename,ss.serviceprice,ss.remark,ss.homepage_cate_parent_id as cate_id,hc.catename';
        return $this->field($field)
            ->alias('ss')
            ->join('dp_homepage_cate hc','ss.homepage_cate_parent_id = hc.id')
            ->where($where)
            ->limit(5)
            ->select();
    }

    /***
     * 获取服务详情
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function bizServiceDetail($params)
    {
        $where['ss.id'] = $params['service_id'];
        $field = 'ss.id,ss.seller_id,ss.servicename,ss.serviceprice,ss.remark,s.start_time,s.end_time,s.sellername,s.address,s.seller_pic3,hc.catename';
        return $this->field($field)
            ->alias('ss')
            ->join('dp_seller s','ss.seller_id = s.id','left')
            ->join('dp_homepage_cate hc','ss.homepage_cate_parent_id = hc.id','left')
            ->where($where)
            ->find();
    }

    /***
     * 获取指定类别下的已审核通过的所有服务
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCategoryBizService($params)
    {
        $where['ss.is_delete'] = 0;
        $where['ss.is_release'] = 1;
        $paginate = $params['paginate'];
        $where['ss.seller_id'] = $params['seller_id'];
        $where['ss.homepage_cate_parent_id'] = $params['cate_id'];
        $field = 'ss.id,ss.homepage_cate_parent_id,ss.servicename,ss.serviceprice,ss.remark,hc.catename';
        return $this
            ->field($field)
            ->alias('ss')
            ->join('dp_homepage_cate hc','ss.homepage_cate_parent_id = hc.id','left')
            ->where($where)
            ->page($paginate,10)
            ->select();
    }
}