<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/27
 * Time: 11:33
 */

namespace app\common\logic;

use app\common\model\UserCard as UserCardModel;
use app\common\model\OrderDetail as OrderDetailModel;
use app\common\model\UserBuycard as UserBuycardModel;
use app\common\model\PlatformCard as PlatformCardModel;
use app\common\model\ServiceProtocol as ServiceProtocolModel;
class UserCardCenter extends Base
{
    /**
     * 平台卡表模型
     * @var PlatformCardModel|null
     */
    protected $platformCardModel = null;

    /***
     * 服务协议模型
     * @var null
     */
    protected $serviceProtocolModel = null;

    /***
     * 用户购买卡记录模型
     * @var null
     */
    protected $userBuycardModel = null;

    /***
     * 用户卡模型
     * @var null
     */
    protected $userCardModel = null;

    /***
     * 用户订单流水模型
     * @var null
     */
    protected $orderDetailModel = null;
    /**
     * 构造方法
     * PlatformCardModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userCardModel = new UserCardModel();
        $this->orderDetailModel = new OrderDetailModel();
        $this->userBuycardModel = new UserBuycardModel();
        $this->platformCardModel = new PlatformCardModel();
        $this->serviceProtocolModel = new ServiceProtocolModel();
    }

    /***
     * 卡种类别列表
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cardCategories($params)
    {
        $params['paginate'] = $params['paginate'] ? $params['paginate'] : 1;
        return $this->platformCardModel->cardCategories($params);
    }

    /***
     * 查看卡详情|购买指定的卡
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCardDetail($params)
    {
        return $this->platformCardModel->getCardDetail($params);
    }

    /***
     * 获取卡详情
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCardInfo($params)
    {
        return $this->platformCardModel->getCardInfo($params);
    }

    /***
     * 用户购买卡订单记录表
     * @param $params
     * @return mixed
     */
    public function addUserBuyCard($params)
    {
        return $this->userBuycardModel->addUserBuyCard($params);
    }

    /***
     * 新增用户卡
     * @param $params
     * @return false|int
     */
    public function addUserCard($params)
    {
        return $this->userCardModel->addUserCard($params);
    }

    /***
     * 记录用户买卡订单流水
     * @param $params
     * @return false|int
     */
    public function addUserBuyCardOrder($params)
    {
        return $this->orderDetailModel->addUserBuyCardOrder($params);
    }

    /***
     * 查看我的订单
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function userMyOrder($params)
    {
        $params['paginate'] = $params['paginate'] ? $params['paginate'] : 1;
        return $this->userBuycardModel->userMyOrder($params);
    }

    /***
     * 查看我的订单详情
     * @param $params
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catMyOrderDetail($params)
    {
        return $this->userBuycardModel->catMyOrderDetail($params);
    }
    /***
     * 卡包中心使用说明
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function instructions()
    {
        return $this->serviceProtocolModel->instructions();
    }
}