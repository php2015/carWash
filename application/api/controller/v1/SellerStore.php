<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 10:14
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\SellerStore as SellerStoreService;

/***
 * 商家店铺控制器
 * Class SellerStore
 * @package app\api\controller\v1
 */
class SellerStore extends Base
{
    /**
     * 商家端服务业务类
     * @var SellerStore|null
     */
    protected $sellerStoreService = null;

    /***
     * 重写构造函数
     * SellerStore constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sellerStoreService = new SellerStoreService();
    }

    /***
     * 商家入驻前请求省份城市,营业项目
     */
    public function SellerEnter()
    {
        $this->sellerStoreService->SellerEnter();
        list($this->status,$this->message,$this->data) = [
            $this->sellerStoreService->status,
            $this->sellerStoreService->message,
            $this->sellerStoreService->data,
        ];
    }

    /***
     * 商家入驻申请
     */
    public function SellerEnterApply()
    {
        $params = [
            'shopkeeper'  => input('shopkeeper', '', 'trim'),
            'contactphone'=> input('contactphone', '', 'trim'),
            'sellername'  => input('sellername', '', 'trim'),
            'provinces_id'=> input('provinces_id/d', 0),
            'address'     => input('address', '', 'trim'),
            'homepage_cate_parent_id'=> input('homepage_cate_parent_id', '', 'trim'),
            'seller_pic1' => input('seller_pic1/d', 0),
        ];
        $this->sellerStoreService->SellerEnterApply($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerStoreService->status,
            $this->sellerStoreService->message,
            $this->sellerStoreService->data,
        ];
    }
    /***
     * 获取当前商家店铺信息
     * @param $seller_id [商家id]
     */
    public function getStoreInfo()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->sellerStoreService->getStoreInfo($params['seller_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerStoreService->status,
            $this->sellerStoreService->message,
            $this->sellerStoreService->data,
        ];
    }

    /***
     * 获取店铺编辑信息
     */
    public function getEditStoreInfo()
    {
        $params = [
            'seller_id' => $this->sellerid,
        ];
        $this->sellerStoreService->getEditStoreInfo($params['seller_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerStoreService->status,
            $this->sellerStoreService->message,
            $this->sellerStoreService->data,
        ];
    }

    /***
     * 更新店铺信息
     */
    public function updateStoreInfo()
    {
        $params = [
            'seller_id'     => $this->sellerid,       //商家id
            'start_time'    => input('start_time/d',0),       //开始营业时间
            'end_time'      => input('end_time/d',0),         //结束营业时间
            'seller_pic2'   => input('seller_pic2', '', 'trim'),   //店铺图片
            'seller_pic3'   => input('seller_pic3', '', 'trim'),//店铺介绍图片
        ];
        $this->sellerStoreService->updateStoreInfo($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerStoreService->status,
            $this->sellerStoreService->message,
            $this->sellerStoreService->data,
        ];
    }
}