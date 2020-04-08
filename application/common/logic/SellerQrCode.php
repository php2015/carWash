<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/19
 * Time: 20:11
 */

namespace app\common\logic;

use app\common\model\User as UserModel;//用户模型
use app\common\model\UserCard as UserCardModel;//用户卡模型
use app\common\model\UserOrder as UserOrderModel;//用户订单模型
use app\common\model\UserMessage as UserMessageModel;//用户消息模型
use app\common\model\OrderDetail as OrderDetailModel;//订单流水模型
use app\common\model\SellerService as SellerServiceModel;//商家服务模型
use app\common\model\SellerBalance as SellerBalanceModel;//商家流水模型
use app\common\model\SellerMessage as SellerMessageModel;//商家消息模型
use app\common\model\UserCardStatement as UserCardStatementModel;//用户卡消费模型
use app\common\model\UserConsumerdetails as UserConsumerdetailsModel;//用户卡消费模型

class SellerQrCode extends Base
{
    /***
     * 用户模型
     * @var null
     */
    protected $userModel = null;

    /***
     * 用户卡模型
     * @var UserCardModel|null
     */
    protected $userCardModel = null;

    /***
     * 用户订单模型
     * @var UserOrderModel|null
     */
    protected $userOrderModel = null;

    /***
     * 用户消息消息模型
     * @var UserMessageModel|null
     */
    protected $userMessageModel = null;

    /***
     * 订单流水模型
     * @var OrderDetailModel|null
     */
    protected $orderDetailModel = null;

    /***
     * 商家服务模型
     * @var SellerServiceModel|null
     */
    protected $sellerServiceModel = null;

    /***
     * 商家流水模型
     * @var SellerBalanceModel|null
     */
    protected $sellerBalanceModel = null;

    /***
     * 商家消息模型
     * @var SellerMessageModel|null
     */
    protected $sellerMessageModel = null;

    /***
     * 用户卡消费模型
     * @var UserCardStatementModel|null
     */
    protected $userCardStatementModel = null;

    /***
     * 用户消费记录模型
     * @var UserConsumerdetailsModel|null
     */
    protected $userConsumerdetailsModel = null;

    /**
     * 构造方法
     * UserOrderModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new  UserModel();//用户模型
        $this->userCardModel = new UserCardModel();//用户卡模型
        $this->userOrderModel = new UserOrderModel();//订单模型
        $this->userMessageModel = new UserMessageModel();//商家消息模型
        $this->orderDetailModel = new OrderDetailModel();//订单流水模型
        $this->sellerServiceModel = new SellerServiceModel();//商家服务模型
        $this->sellerBalanceModel = new SellerBalanceModel();//商家流水模型
        $this->sellerMessageModel = new SellerMessageModel();//商家消息模型
        $this->userCardStatementModel = new UserCardStatementModel();//用户卡消费模型
        $this->userConsumerdetailsModel = new UserConsumerdetailsModel();//用户消费明细模型
    }

    /***
     * 获取用户信息
     * @param $userId
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserInfo($userId)
    {
        return $this->userModel->getUserInfo($userId);
    }
    /***
     * 获取当前用户所有可使用的权益卡 card_type =1
     * @param $userId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function canUseQyCard($userId)
    {
        return $this->userCardModel->canUseQyCard($userId);
    }
    /***
     * 获取用户卡信息
     * @param $userId
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserCardInfo($userId)
    {
        return $this->userCardModel->getUserCardInfo($userId);
    }

    /***
     * 权益卡结算,获取用户卡信息
     * @param $userCardId|array
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryCardInfo($userCardId)
    {
        $strId = implode(',',$userCardId);
        return $this->userCardModel->queryCardInfo($strId);
    }

    /***
     * 次数卡获取卡信息
     * @param $userCardId|int
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function queryCardDetail($userCardId)
    {
        return $this->userCardModel->queryCardDetail($userCardId);
    }
    /***
     * 获取用户当前次卡当月消费次数
     * @param $params
     * @return int|string
     */
    public function monthUseCiShu($params)
    {
        return $this->userCardStatementModel->monthUseCiShu($params);
    }
    /***
     * 获取用户当前次卡总消费次数
     */
    public function totalUseCiShu($params)
    {
        return $this->userCardStatementModel->totalUseCiShu($params);
    }

    /***
     * 获取平台次卡总使用次数和单月可使用次数
     * @param $cardId
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function totalPlatformCardCiShu($cardId)
    {
        return $this->userCardModel->totalPlatformCardCiShu($cardId);
    }

    /***
     * 获取当前服务是否支持次卡结算
     * @param $sellerId
     * @param $serviceId
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ServiceIsTimesCard($sellerId,$serviceId)
    {
        return $this->sellerServiceModel->ServiceIsTimesCard($sellerId,$serviceId);
    }

    /***
     * 扣除用户卡的积分
     * @param $params
     * @return array|false
     * @throws \Exception
     */
    public function deductUserIntegral($params)
    {
        return $this->userCardModel->deductUserIntegral($params);
    }

    /***
     * 扣除用户卡次数
     * @param $userTimesCardId
     * @param $deductUserTimes
     * @return UserCardModel
     */
    public function deductUserTimes($userTimesCardId,$deductUserTimes)
    {
        return $this->userCardModel->deductUserTimes($userTimesCardId,$deductUserTimes);
    }
    /***
     * 商家进账
     * @param $income
     * @return mixed
     */
    public function addIncome($income)
    {
        return $this->sellerBalanceModel->addIncome($income);
    }

    /***
     * 新增用户卡消费记录
     * @param $userKaXfDetailArr
     * @return false|int
     */
    public function addCsCardXf($userKaXfDetailArr)
    {
        return $this->userCardStatementModel->addCsCardXf($userKaXfDetailArr);
    }

    /***
     * 新增用户权益卡消费记录
     * @param $userKaXfDetailArr
     * @return array|false
     * @throws \Exception
     */
    public function addQeCardXf($userKaXfDetailArr)
    {
        return $this->userCardStatementModel->addQeCardXf($userKaXfDetailArr);
    }
    
    /***
     * 添加订单
     * @param $order
     * @return int
     */
    public function addOrder($order)
    {
        return $this->userOrderModel->addOrder($order);
    }

    /***
     * 记录订单流水
     * @param $orderFlow
     * @return mixed
     */
    public function addOrderFlow($orderFlow)
    {
        return $this->orderDetailModel->addOrderFlow($orderFlow);
    }

    /***
     * 新增用户消费明细记录
     * @param $userXfDetail
     * @return false|int
     */
    public function addUserXfDetail($userXfDetail)
    {
        return $this->userConsumerdetailsModel->addUserXfDetail($userXfDetail);
    }

    /***
     * 新订单新增商家消息
     * @param $sellMessage
     * @return false|int
     */
    public function addSellerMessage($sellMessage)
    {
        return $this->sellerMessageModel->addSellerMessage($sellMessage);
    }

    /***
     * 用户扣款消息通知
     * @param $userMessage
     * @return false|int
     */
    public function addUserMessage($userMessage)
    {
        return $this->userMessageModel->addUserMessage($userMessage);
    }
}