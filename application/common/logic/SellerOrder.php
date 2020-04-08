<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/18
 * Time: 15:24
 */

namespace app\common\logic;

use app\common\logic\Evaluate as EvaluateLogic;
use app\common\model\UserOrder as UserOrderModel;
use app\common\model\SellerStaff as SellerStaffModel;

/***
 * 商家订单逻辑类
 * Class SellerOrder
 * @package app\common\logic
 */
class SellerOrder extends Base
{
    /**
     * 商户模型
     * @var UserOrderModel|null
     */
    protected $userOrderModel = null;

    /***
     * 商家员工模型
     * @var null
     */
    protected $sellerStaffModel = null;
    /***
     * 评论模型
     * @var null
     */
    protected $evaluateLogic = null;
    /**
     * 构造方法
     * SellerStaffModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->evaluateLogic = new EvaluateLogic();
        $this->userOrderModel = new UserOrderModel();
        $this->sellerStaffModel = new SellerStaffModel();
    }

    /***
     * 获取当前服务的订单
     * @param $params
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getServiceOrder($params)
    {
        return $this->userOrderModel->getServiceOrder($params);
    }

    /***
     * 获取订单详情
     * @param $order
     * @param $comment
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catOrderDetail($sellerId,$orderId)
    {

        $where['user_order_id'] = $orderId; //订单id
        $map['seller_id'] = $sellerId;
        $orderDetail = $this->userOrderModel->catOrderDetail($orderId);//订单id
        $orderComment = $this->evaluateLogic->orderComment($where);//获取订单评价
        if($orderComment['replay_id'] == null){
            $orderComment['replay_id'] = 0;
        }
        $data['orderData'] = $orderDetail;
        $data['comment'] = $orderComment;
        return $data;
    }
    /***
     * 获取商家员工列表
     * @param $sellerId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStaffList($sellerId)
    {
        return $this->sellerStaffModel->getStaffList($sellerId);
    }

    /***
     * 获取当前商家的所有订单
     * @param $sellerId
     * @param $seller_staff_id
     * @param $paypriceStr
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getServiceAllOrder($sellerId,$seller_staff_id,$paypriceStr)
    {
        $order = '';
        $where = [];
        //员工,金额 筛选
        if(!empty($seller_staff_id)){
            $where['seller_staff_id'] = $seller_staff_id;
        } elseif(!empty($paypriceStr)) {
            if($paypriceStr == 'desc') {
                $order = 'uo.payprice desc,';
            } elseif($paypriceStr == 'asc') {
                $order = 'uo.payprice asc,';
            }
        }
        $this->userOrderModel->allOrderRead();
        return $this->userOrderModel->getServiceAllOrder($sellerId,$where,$order);
    }
}