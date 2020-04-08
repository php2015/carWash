<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/18
 * Time: 15:22
 */

namespace app\common\service;

use app\common\logic\SellerOrder as SellerOrderLogic;

/***
 * 商家订单业务类
 * Class SellerOrder
 * @package app\common\service
 */
class SellerOrder extends Base
{
    /**
     * 商家订单逻辑类
     * @var SellerOrderLogic|null
     */
    protected $sellerOrderLogic = null;
    /**
     * 构造方法
     * SellerStaffLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerOrderLogic = new SellerOrderLogic();
    }

    /***
     * 获取当前商家服务的订单
     * @param $sellerId
     */
    public function getServiceOrder($params)
    {
        try{
            $serviceOrder = $this->sellerOrderLogic->getServiceOrder($params);
            if(empty($serviceOrder)){
                list($this->status,$this->message) = [0,'暂无订单信息'];
                return;
            }
            list($this->status,$this->message,$this->data) = [1, '获取成功', $serviceOrder];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }

    /***
     * 查看订单详情
     * @param $params
     */
    public function catOrderDetail($sellerId,$orderId)
    {
        try{
            $catOrderDetail = $this->sellerOrderLogic->catOrderDetail($sellerId,$orderId);
            if(empty($catOrderDetail['orderData'])){
                list($this->status,$this->message) = [0,'暂无订单信息'];
                return;
            }
            list($this->status,$this->message,$this->data) = [1, '获取成功', $catOrderDetail];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'订单信息获取失败'];
        }
    }
    /***
     * 获取当前商家的员工列表
     * @param $sellerId
     */
    public function getStaffList($sellerId)
    {
        try{
            $getStaffList = $this->sellerOrderLogic->getStaffList($sellerId);
            list($this->status,$this->message,$this->data) = [1, '获取成功', $getStaffList];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取失败'];
        }
    }
    /***
     * 获取当前商家的所有订单
     * @param $sellerId
     */
    public function getServiceAllOrder($sellerId,$seller_staff_id,$paypriceStr)
    {
        try{
            $getServiceAllOrder = $this->sellerOrderLogic->getServiceAllOrder($sellerId,$seller_staff_id,$paypriceStr);
            list($this->status,$this->message,$this->data) = [1, '获取成功', $getServiceAllOrder];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,$e->getMessage()];
        }
    }
}