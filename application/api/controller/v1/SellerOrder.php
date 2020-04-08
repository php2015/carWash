<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/18
 * Time: 15:15
 */

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Base;
use app\common\service\SellerOrder as SellerOrderService;

/***
 * 商家订单控制器
 * Class SellerOrder
 * @package app\api\controller\v1
 */
class SellerOrder extends Base
{
    /**
     * 商家端订单业务类
     * @var SellerOrderService|null
     */
    protected $sellerOrderService = null;

    /***
     * 重写构造函数
     * SellerOrder constructor.
     * @param Request|null $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->sellerOrderService = new SellerOrderService();
    }

    /***
     * 商家当前服务的订单
     * @param $seller_id [商家id]
     */
    public function getServiceOrder()
    {
        $params = [
            'seller_service_id'=> input('id/d', 0),  //商家服务id
            'seller_id'        => $this->sellerid,  //商家id
        ];
        $this->sellerOrderService->getServiceOrder($params);
        list($this->status,$this->message,$this->data) = [
            $this->sellerOrderService->status,
            $this->sellerOrderService->message,
            $this->sellerOrderService->data,
        ];
    }

    /***
     * 查看订单详情
     * seller_id 商家id
     * seller_service_id 服务id
     * user_order_id     订单id
     */
    public function catOrderDetail()
    {
        $params = [
            'seller_id' => $this->sellerid,
            'id' => input('user_order_id/d',0), //订单id
        ];
        $this->sellerOrderService->catOrderDetail($params['seller_id'],$params['id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerOrderService->status,
            $this->sellerOrderService->message,
            $this->sellerOrderService->data,
        ];
    }
    /***
     * 获取当前商家所有员工列表
     */
    public function getStaffList()
    {
        $params = [
            'seller_id' => $this->sellerid,  //商家id
        ];
        $this->sellerOrderService->getStaffList($params['seller_id']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerOrderService->status,
            $this->sellerOrderService->message,
            $this->sellerOrderService->data,
        ];
    }
    /***
     * 当前商家的所有订单
     */
    public function getServiceAllOrder()
    {
        $params = [
            'seller_id' => $this->sellerid,  //商家id
            'payprice'  => input('payprice', '','trim'),
            'seller_staff_id'=> input('seller_staff_id', '','trim'),
        ];
        $this->sellerOrderService->getServiceAllOrder($params['seller_id'],$params['seller_staff_id'],$params['payprice']);
        list($this->status,$this->message,$this->data) = [
            $this->sellerOrderService->status,
            $this->sellerOrderService->message,
            $this->sellerOrderService->data,
        ];
    }
}