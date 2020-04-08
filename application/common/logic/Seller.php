<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 20:58
 */

namespace app\common\logic;

use app\common\model\Seller as SellerModel;
use app\common\model\Collect as CollectModel;
use app\common\model\SellerService as SellerServiceModel;

/***
 * 用户端商家模型类
 * Class Seller
 * @package app\common\logic
 */
class Seller extends Base
{
    /***
     * 商家模型
     * @var null
     */
    protected $sellerModel = null;

    /***
     * 商家服务模型
     * @var SellerModel|null
     */
    protected $sellerServiceModel = null;

    /***
     * 热门搜索模型
     */
    protected $hotsearch = null;

    /***
     * 收藏模型
     * @var CollectModel|null
     */
    protected $collectModel = null;

    /**
     * 构造方法
     * SellerModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerModel = new SellerModel();
        $this->collectModel = new CollectModel();
        $this->sellerServiceModel = new SellerServiceModel();
    }

    /***
     * 获取商家列表
     * @param $latitude
     * @param $longitude
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getAllBiz($params)
    {
        $latitude  = $params['latitude'];
        $longitude = $params['longitude'];
        $search = $params['search'];
        $paginate = $params['paginate'] ? $params['paginate'] : 1;
        if($params['orderAll'] == 0){ //如果是综合排序
            $order = 'order_num asc'; //则按照后台排序值正序排序
        } else {
            if(!empty($params['orderComment'])){
                if($params['orderComment'] == 'desc'){
                    $orderComment = 'asc';
                } elseif($params['orderComment'] == 'asc'){
                    $orderComment = 'desc';
                }
            }
            if(empty($params['orderRange']) && !empty($params['orderComment'])){ //如果只有评价排序而没有距离排序
                $order = 'comment_type '.$orderComment;
            } elseif(!empty($params['orderRange']) && empty($params['orderComment'])){ //距离排序
                $order = 'range '.$params['orderRange'];
            } elseif(!empty($params['orderRange']) && !empty($params['orderComment'])){ //好评距离排序
                $order = 'range '.$params['orderRange'].',totalComment '.$orderComment;
            }
        }
        return $this->sellerModel->getAllBiz($latitude,$longitude,$paginate,$order,$search);
    }

    /***
     * 获取指定分类下的所有的商家
     * @param $latitude
     * @param $longitude
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getAllCateBiz($params)
    {
        $latitude  = $params['latitude'];
        $longitude = $params['longitude'];
        $cateId = $params['cate_id'];
        $paginate = $params['paginate'] ? $params['paginate'] : 1;
        if($params['orderAll'] == 0){ //如果是综合排序
            $order = 'order_num asc'; //则按照后台排序值正序排序
        } else {
            if(!empty($params['orderComment'])){
                if($params['orderComment'] == 'desc'){
                    $orderComment = 'asc';
                } elseif($params['orderComment'] == 'asc'){
                    $orderComment = 'desc';
                }
            }
            if(empty($params['orderRange']) && !empty($params['orderComment'])){ //如果只有评价排序而没有距离排序
                $order = 'comment_type '.$orderComment;
            } elseif(!empty($params['orderRange']) && empty($params['orderComment'])){ //距离排序
                $order = 'range '.$params['orderRange'];
            } elseif(!empty($params['orderRange']) && !empty($params['orderComment'])){ //好评距离排序
                $order = 'range '.$params['orderRange'].',totalComment '.$orderComment;
            }
        }
        return $this->sellerModel->getAllCateBiz($latitude,$longitude,$paginate,$order,$cateId);
    }

    /***
     * 获取商家详情
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBizDetail($params)
    {
        return $this->sellerModel->getBizDetail($params);
    }

    /***
     * 获取商家服务
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBizService($params)
    {
        return $this->sellerServiceModel->getBizService($params);
    }

    /***
     * 获取服务详情
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function bizServiceDetail($params)
    {
        return $this->sellerServiceModel->bizServiceDetail($params);
    }

    /***
     * 获取指定类别下的所有服务
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCategoryBizService($params)
    {
        return $this->sellerServiceModel->getCategoryBizService($params);
    }
    /***
     * 查看用户是否收藏商家
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isCollectionBiz($params)
    {
        return $this->collectModel->isCollectionBiz($params);
    }

    /***
     * 查询是否已在收藏列表中,但是被移除
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isCollect($params)
    {
        return $this->collectModel->isCollect($params);
    }

    /***
     * 更新收藏状态
     * @param $params
     * @return CollectModel
     */
    public function updateCollect($params)
    {
        return $this->collectModel->updateCollect($params);
    }

    /***
     * 新增收藏
     * @param $params
     * @return false|int
     */
    public function addCollect($params)
    {
        return $this->collectModel->addCollect($params);
    }

}