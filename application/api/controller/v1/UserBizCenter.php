<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/25
 * Time: 20:43
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\Seller as SellerService;

/***
 * 用户端商家控制器
 * Class UserBizCenter
 * @package app\api\controller\v1
 */
class UserBizCenter extends Base
{
    /**
     * 商家业务类
     * @var SellerService|null
     */
    protected $sellerService = null;

    /***
     * 重写构造函数
     * UserBizCenter constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sellerService = new SellerService();
    }

    /***
     * 获取所有商家
     * @param $latitude  [纬度]
     * @param $longitude [经度]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllBiz()
    {
        $params = [
            'user_id'  =>$this->uid,
            'search'   =>input('search','','trim'),         //搜索参数
            'latitude' =>input('latitude','','trim'),
            'longitude'=>input('longitude','','trim'),
            'paginate' =>input('paginate/d',1),             //分页参数
            'orderAll' =>input('orderAll/d',0),             //综合排序 0,默认综合排序,1取消综合排序
            'orderRange'=>input('orderRange','','trim'),    //距离排序
            'orderComment'=>input('orderComment','','trim'),//评价排序,3好评,2一般,1差评
        ];
        $this->sellerService->getAllBiz($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }

    /***
     * 获取指定分类下的所有商家
     * @param $latitude  [纬度]
     * @param $longitude [经度]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllCateBiz()
    {
        $params = [
            'cate_id'  =>input('cate_id/d',0),        //分类id
            'latitude' =>input('latitude','','trim'),
            'longitude'=>input('longitude','','trim'),
            'paginate' =>input('paginate/d',1),             //分页参数
            'orderAll' =>input('orderAll/d',0),             //综合排序 0,默认综合排序,1取消综合排序
            'orderRange'=>input('orderRange','','trim'),    //距离排序
            'orderComment'=>input('orderComment','','trim'),//评价排序,3好评,2一般,1差评
        ];
        $this->sellerService->getAllCateBiz($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }
    /***
     * 商家详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBizDetail()
    {
        $params = [
            'seller_id'=>input('seller_id/d',0),
        ];
        $this->sellerService->getBizDetail($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }
    /***
     * 商家服务,默认显示5条
     */
    public function getBizService()
    {
        $params = [
            'seller_id'=>input('seller_id/d',0),
        ];
        $this->sellerService->getBizService($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }
    /***
     * 服务详情
     */
    public function bizServiceDetail()
    {
        $params = [
            'service_id'=>input('service_id/d',0),
        ];
        $this->sellerService->bizServiceDetail($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }

    /***
     * 获取指定类别下的已审核通过的所有服务
     */
    public function getCategoryBizService()
    {
        $params = [
            'cate_id' => input('cate_id/d',0),
            'seller_id'=>input('seller_id/d',0),
            'paginate' =>input('paginate/d',1),//分页参数
        ];
        $this->sellerService->getCategoryBizService($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }
    /***
     * 查看用户是否收藏商家
     */
    public function isCollectionBiz()
    {
        $params = [
            'user_id' => $this->uid,
            'seller_id'=>input('seller_id/d',0),
        ];
        $this->sellerService->isCollectionBiz($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }

    /***
     * 用户收藏商家
     */
    public function CollectionBiz()
    {
        $params = [
            'user_id' => $this->uid,
            'collect_id'=>input('collect_id/d',0),
            'seller_id'=>input('seller_id/d',0),
            'is_collect'=>input('is_collect/d',0), //1已收藏,2未收藏
        ];
        $this->sellerService->CollectionBiz($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerService->status,
            $this->sellerService->message,
            $this->sellerService->data,
        ];
    }
}