<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 10:28
 */

namespace app\common\logic;

use app\common\model\Seller as SellerModel;  //商家
//use app\common\model\Evaluate as EvaluateModel; //评论
use app\common\model\SellerStaff as SellerStaffModel;//商家员工
use app\common\model\SellerPosition as SellerPositionModel;//员工职位
use app\common\model\HomepageCate as HomepageCateModel;//首页分类
use app\common\model\HomepageArea as HomepageAreaModel;//地域
/***
 * 商家店铺信息逻辑类
 * Class SellerStore
 * @package app\common\logic
 */
class SellerStore extends Base
{
    /***
     * 商家店铺模型
     * @var null
     */
    protected $sellerModel = null;

    /***
     * 评论模型
     * @var null
     */
    //protected $evaluateModel = null;

    /***
     * 营业模型
     * @var homepageCateModel|null
     */
    protected $homepageCateModel = null;
    /***
     * 地域模型
     * @var homepageCateModel|null
     */
    protected $homepageAreaModel = null;
    /***
     * 员工模型
     */
    protected $sellerStaffModel = null;
    /***
     * 职位模型
     * @var null
     */
    protected $sellerPositionModel = null;
    /**
     * 构造方法
     * SellerStaffModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerModel = new SellerModel();
        //$this->evaluateModel = new EvaluateModel();
        $this->sellerStaffModel = new SellerStaffModel;
        $this->sellerPositionModel = new SellerPositionModel();
        $this->homepageCateModel = new HomepageCateModel();
        $this->homepageAreaModel = new HomepageAreaModel();
    }

    /***
     * 获取省份城市
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getProvince()
    {
        return $this->homepageAreaModel->getProvince();
    }

    /***
     * 获取所有的营业项目
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBusiness()
    {
        return $this->homepageCateModel->getBusiness();
    }
    /***
     * 获取有子分类的营业项目
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDoBusiness($params)
    {
        $str = $this->sellerModel->getHomePageCateParentId($params); //获取当前商家有那些营业项目
        $strId = $str['homepage_cate_parent_id'];
        $arrId = array_filter(explode(',',$strId)); //去除空格
        $cateId = implode($arrId,',');

        return $this->homepageCateModel->getDoBusiness($cateId);
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
        return $this->homepageCateModel->getBusinessLevel($parentId);
    }
    /***
     * 商家入驻申请
     * @param $params
     * @return false|int
     */
    public function SellerEnterApply($params)
    {
        return $this->sellerModel->SellerEnterApply($params);
    }

    /***
     * 新增商家入驻店主职位
     * @param $params
     * @return mixed
     */
    public function addPosition($params)
    {
        return $this->sellerPositionModel->addPosition($params);
    }

    /***
     * 新增员工->店主
     * @param $params
     * @return int
     */
    public function addStaff($params)
    {
        return $this->sellerStaffModel->addStaff($params);
    }

    /***
     * 获取店铺评论
     * @param $params
     * @return array|\think\Collection|\think\model\Collection
     */
    /*
    public function getStoreComment($params)
    {
        return $this->evaluateModel->commentsList($params);
    }
    */
    /***
     * 获取店铺评论数量
     * @param $sellerId
     * @return array|\think\Collection|\think\model\Collection
     */
    /*
    public function SellerCommentCount($sellerId)
    {
        $where['seller_id'] = $sellerId;
        return $this->evaluateModel->commentsType($where);
    }
    */
    /***
     * 获取店铺信息
     * @param $sellerId
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStoreInfo($sellerId)
    {
        return $this->sellerModel->getStoreInfo($sellerId);
    }
    /***
     * 更新店铺信息
     * @param $sellerId
     * @param $params
     * @return mixed
     */
    public function updateStoreInfo($sellerId,$params)
    {
        return $this->sellerModel->updateStoreInfo($sellerId,$params);
    }
}