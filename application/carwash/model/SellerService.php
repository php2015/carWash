<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/6
 * Time: 11:10
 */

namespace app\carwash\model;



use think\Db;
use think\Model;

class SellerService extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 查看所有商家服务
     * @param $condition
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function sellerServiceList($condition)
    {
        $subQuery = Db::name('seller_service')
            ->field("ss.id,ss.servicename,ss.create_time,ss.serviceprice,ss.is_timescard,ss.is_release,
            IF(ss.is_release=1,ss.update_time,'') as update_time,ss.homepage_cate_parent_id,ss.homepage_cate_id,s.sellername,hc.catename")
            ->alias('ss')
            ->join('dp_seller s','ss.seller_id = s.id','left')
            ->join('dp_homepage_cate hc','ss.homepage_cate_parent_id = hc.id','left')
            ->where('ss.is_delete',0) //筛选出
            ->buildSql();
        return Db::table($subQuery. ' dp_seller_service')
            ->field('dp_seller_service.*,hc.catename as soncatename')
            ->join('dp_homepage_cate hc','dp_seller_service.homepage_cate_id = hc.id','left')
            ->where($condition)
            ->paginate();
    }

    /***
     * 获取服务状态
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getServiceStatus($id)
    {
        $where['id'] = $id;
        return $this->where($where)->find();
    }

    /***
     * 修改服务状态
     */
    public function updateServiceStatus($serviceId,$isRease)
    {
        $where['id'] = $serviceId;
        return $this->where($where)->update(['is_release'=>$isRease]);
    }

    /***
     * 查询当前修改服务的商家名,服务名
     * @param $serviceId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryWriteInfo($serviceId)
    {
        $where['ss.id'] = $serviceId;
        return $this->field('ss.id as seller_service_id,s.id as seller_id,ss.servicename,s.sellername')
                    ->alias('ss')
                    ->join('dp_seller s','ss.seller_id = s.id','left')
                    ->where($where)
                    ->find();
    }

    /***
     * 变更服务状态写入消息表
     * @param $writeInfo
     * @return int|string
     */
    public function addServiceMessage($writeInfo)
    {
        return Db::name('seller_message')->insert($writeInfo);
    }
    /***
     * 查询需要编辑的服务信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function editSellerService($id)
    {
        return Db::name('seller_service')
            ->field("ss.id,ss.servicename,ss.create_time,ss.serviceprice,ss.is_timescard,ss.is_release,
            IF(ss.is_release=1,ss.update_time,'') as update_time,ss.homepage_cate_parent_id,ss.homepage_cate_id,s.sellername,hc.catename")
            ->alias('ss')
            ->join('dp_seller s','ss.seller_id = s.id','left')
            ->join('dp_homepage_cate hc','ss.homepage_cate_id = hc.id','left')
            ->where('ss.id = '.$id.' and ss.is_delete = 0')
            ->find();
    }

    /***
     * 更新服务价格
     * @param $id
     * @param $editPriceData
     * @return SellerService
     */
    public function updateSellerService($id,$editPriceData)
    {
        return $this->where('id',$id)->update($editPriceData);
    }

    /***
     * 删除商家服务
     * @param $id
     * @return SellerService
     */
    public function delSellerService($id)
    {
        return $this->where('id',$id)->update(['is_delete'=>1]);
    }

    /***
     * 查看首页服务类别
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function showPageCate($searchCondition)
    {
        return Db::name('homepage_cate')
            ->field("id,catename,parent_id,path,create_time,order_num,icon,is_enable,concat(path,',',id) as paths")
            ->where('is_delete',0)
            ->where($searchCondition)
            ->order("paths")
            ->paginate();
    }

    /***
     * 添加时获取顶级分类
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHomePageCate()
    {
        return  Db::name('homepage_cate')
            ->field("id,catename,path,CONCAT(path,',',id) as paths")
            ->where('is_enable =1 and is_delete=0 and parent_id = 0')
            ->order("paths")
            ->select();
    }

    /***
     * 获取服务分类的父级id
     * @param $cateId
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getParentId($cateId)
    {
        return Db::name('homepage_cate')->where("id",$cateId)->find();
    }

    /***
     * 新增首页服务类别并返回id
     * @param $addHomePageCate
     * @return mixed
     */
    public function addHomePageCate($addHomePageCate)
    {
        Db::name('homepage_cate')->insert($addHomePageCate);
        return $id = Db::name('homepage_cate')->getLastInsID();
    }

    /***
     * 查询编辑的分类信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edithomepagecate($id)
    {
        return Db::name('homepage_cate')->where('id',$id)->find();
    }

    /***
     * 更新信息
     * @param $id
     * @param $editHomePageCate
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateHomePageCate($id,$editHomePageCate)
    {
        return Db::name('homepage_cate')->where('id',$id)->update($editHomePageCate);
    }

    /***
     * 判断是否是父分类
     * @param $strId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isParentCate($strId)
    {
        return Db::name('homepage_cate')->where('is_delete',0)->where('parent_id','in',$strId)->count('id');
    }

    /***
     * 一级分类是否关联商家
     * @param $strId
     * @return int|string
     */
    public function isRelationSeller($strId)
    {
        return Db::name('seller')->where('homepage_cate_parent_id','in',$strId)->count('id');
    }

    /***
     * 删除前查询是否关联服务
     * @param $strId
     * @return int|string
     */
    public function queryIsRelatedServices($strId)
    {
        return Db::name('seller_service')->where('homepage_cate_id','in',$strId)->count('id');
    }

    /***
     * 删除首页分类
     * @param $strId
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delHomePageCate($strId)
    {
        return Db::name('homepage_cate')->where('id','in',$strId)->update(['is_delete'=>1]);
    }
}