<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 16:07
 */

namespace app\common\logic;

use app\common\model\UserOrder as UserOrderModel;
use app\common\model\SellerService as SellerServiceModel;

class SellerService extends Base
{
    /***
     * 商家服务模型
     * @var null
     */
    protected $sellerServiceModel = null;
    /***
     * 商家订单模型
     * @var UserOrderModel|null
     */
    protected $userOrderModel = null;
    /**
     * 构造方法
     * SellerStaffModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerServiceModel = new SellerServiceModel();
        $this->userOrderModel = new UserOrderModel();
    }

    /***
     * 获取当前商家所有服务
     * @param $sellerId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllService($sellerId)
    {
        return $this->sellerServiceModel->getAllService($sellerId);
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
        return $this->sellerServiceModel->getAllInUseService($sellerId);
    }
    /***
     * 查看服务详情
     * @param $id
     * @param $sellerId
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catServiceDetail($id,$sellerId)
    {
        return $this->sellerServiceModel->catServiceDetail($id,$sellerId);
    }

    /***
     * 新增当前商家服务
     * @param $params
     * @return mixed
     */
    public function addService($params)
    {
        return $this->sellerServiceModel->addService($params);
    }
}