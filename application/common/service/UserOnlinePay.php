<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/10/22
 * Time: 10:13
 */

namespace app\common\service;

use think\Db;
use app\common\logic\UserQrCode as UserQrCodeLogic;
use app\common\logic\SellerStaff as SellerStaffLogic;
/***
 * 在线结算服务类
 * Class UserOnlinePay
 * @package app\common\service
 */
class UserOnlinePay extends Base
{
    /***
     * 用户扫码支付逻辑类
     * @var null
     */
    protected $userQrCodeLogic = null;

    /**
     * 商家员工逻辑类
     * @var SellerStaffLogic|null
     */
    protected $sellerStaffLogic = null;

    /**
     * 构造方法
     * SellerStaffLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userQrCodeLogic = new UserQrCodeLogic();
        $this->sellerStaffLogic = new SellerStaffLogic();
    }

    /***
     * 据商家id获取店主id
     * @param $sellerId
     * @return array|bool|false|\PDOStatement|string|\think\Model
     */
    public function getStaffId($sellerId)
    {
        try{
            return $this->sellerStaffLogic->getStaffId($sellerId);
        }catch(\Exception $e){
            return false;
        }
    }

    /***
     * 获取当前服务是否支持次卡结算
     * @param $sellerId
     * @param $serviceId
     * @return bool
     */
    public function ServiceIsTimesCard($sellerId,$serviceId)
    {
        try{
            return $this->userQrCodeLogic->ServiceIsTimesCard($sellerId,$serviceId);
        }catch(\Exception $e){
            return false;
        }
    }

    /***
     * 获取用户信息
     * @param $userId
     * @return array|bool|false|\PDOStatement|string|\think\Model
     */
    public function getUserInfo($userId)
    {
        try{
            return $this->userQrCodeLogic->getUserInfo($userId);
        }catch(\Exception $e){
            return false;
        }
    }

    /***
     * 因为次数可能为0,所以所有异常,则返回字符串的 'false';
     * 获取用户当前次卡当月消费次数
     * @param $userId
     * @param $cardId
     * @return bool|int|string
     */
    public function monthUseCiShu($userId,$cardId)
    {
        try{
            $params['user_id'] = $userId; //用户id
            $params['user_card_id'] = $cardId; //用户卡id
            return $this->userQrCodeLogic->monthUseCiShu($params);
        }catch(\Exception $e){
            return 'false';
        }
    }

    /***
     * 因为次数可能为0,所以所有异常,则返回字符串的 'false';
     * 获取用户当前次卡总消费次数
     */
    public function totalUseCiShu($userId,$cardId)
    {
        try{
            $params['user_id'] = $userId; //用户id
            $params['user_card_id'] = $cardId; //用户卡id
            return $this->userQrCodeLogic->totalUseCiShu($params);
        }catch(\Exception $e){
            return 'false';
        }
    }
    /***
     * 获取平台次卡总使用次数和单月可使用次数
     * @param $cardId
     * @return array|bool|false|\PDOStatement|string|\think\Model
     */
    public function totalPlatformCardCiShu($cardId)
    {
        try{
            return $this->userQrCodeLogic->totalPlatformCardCiShu($cardId);
        }catch(\Exception $e){
            return 'false';
        }
    }


    /***
     * 在线购买服务
     */
    public function onlinePayMent($params)
    {
        try{
            $sellerId = $params['seller_id'];
            $sellerServiceId = $params['seller_service_id'];    //商家服务id
            $userId = $params['user_id'];                       //用户id
            $cardId = $params['card_id'];                       //卡id
            $sellerName = $params['sellername'];                //商家名称
            $settlementType = $params['settlement_type'];       //结算方式
            $getStaffId = $this->getStaffId($sellerId);         //获取店主id
            $serviceIsTimesCard = $this->ServiceIsTimesCard($sellerId,$sellerServiceId);//获取当前服务信息
            $getUserInfo = $this->getUserInfo($userId);         //获取用户信息
            if(false == $getStaffId || empty($getStaffId)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
            if(false == $getUserInfo || empty($getUserInfo)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
            if(false == $serviceIsTimesCard || empty($serviceIsTimesCard)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
            $staffId = $getStaffId['id'];//店主id

            $serviceName = $serviceIsTimesCard['servicename']; //查询商家服务表获取服务名称
            $servicePrice = $serviceIsTimesCard['serviceprice'];//查询商家服务表获取服务价格
            $isTimesCard = $serviceIsTimesCard['is_timescard'];//查询商家服务表获取是否支持次卡结算

            if($settlementType == 1) {
                //1权益卡结算,2循环查询当前用户可使用权益卡逻辑,开始,3卡类型,用户id,查询出当前用户所有可使用的权益卡
                $canUseQyCard = $this->userQrCodeLogic->canUseQyCard($userId);
                //1如果结算方式为权益卡,2按时间正序查询当前用户所有权益卡,从第一张卡开始扣款
                //3如果余额不足,按照购买时间正序查询,直到积分扣除完毕为止,扣款过程需要记录用户卡id,扣除后的余额
                //4如果单张卡已扣完,则余额为0,如果积分扣除完毕,变更卡状态为已消费完毕
                $takeMoney = $servicePrice; //需要支付的积分,服务价格
                $tookMoney = 0; //已经扣的积分
                $takeResult = [];//准备批量更新权益卡数值的数据池
                $qyTotal = 0;
                foreach ($canUseQyCard as &$val) {
                    $qyTotal += $val['balance_value'];
                    if ($val['balance_value'] > 0 && $tookMoney < $takeMoney) {
                        $value = $val['balance_value'];
                        $take = ($value < ($takeMoney - $tookMoney)) ? $value : ($takeMoney - $tookMoney); //扣的积分
                        $tookMoney += $take;
                        if ($val['balance_value'] > $take) { //根据扣除的值修改状态
                            $takeResult[] = ['id' => $val['id'], 'balance_value' => $val['balance_value'] - $take, 'status' => 0];  //若积分扣除完毕,状态为0
                        } else {
                            $takeResult[] = ['id' => $val['id'], 'balance_value' => $val['balance_value'] - $take, 'status' => 1]; //若有积分剩余,状态为1
                        }
                    }
                    if ($tookMoney == $takeMoney) {//如果已扣满金额,则退出循环
                        break;
                    }
                }
                if ($qyTotal < $servicePrice) { //如果用户当前的所有权益卡的权益值小于服务价格,return false
                    list($this->status, $this->message) = [0, '您当前权益值不足'];
                    return;
                }
                //循环查询当前用户可使用权益卡逻辑结束,
                //权益卡开始结算流程,1扣除用户权益卡积分,2商家流水表记录数据,3用户卡消费记录表记录数据,4生成订单表数据,5订单流水表记录数据
                //6.记录用户消费明细<用户消费明细表>,7发送商家消息通知<商家消息表>,8发送用户消息通知<循环写入用户消息表>
                Db::startTrans();//开启事务
                $userCardId = [];
                foreach($takeResult as $k=>$v){
                    $userCardId[] = $v['id']; //获取用户卡表id
                }
                $queryCardInfo = $this->userQrCodeLogic->queryCardInfo($userCardId);//查询卡名
                //扣除用户卡的积分
                $deductUserIntegral = $this->userQrCodeLogic->deductUserIntegral($takeResult);//扣除用户卡积分
                if ($deductUserIntegral) { //用户消费积分扣除
                    $incomeArr = [];//商家流水数据池
                    $incomeArr['seller_id'] = $sellerId;
                    $incomeArr['seller_service_id'] = $sellerServiceId;
                    $incomeArr['price'] = $servicePrice;
                    $incomeArr['is_balance'] = 1;
                    $addIncome = $this->userQrCodeLogic->addIncome($incomeArr);//记录商家消费流水
                    if ($addIncome) {
                        $userKaXfDetailArr = [];//用户卡消费明细数据池
                        foreach($userCardId as $k=>$v){
                            $userKaXfDetailArr[$k]['card_type'] = 1;//权益卡
                            $userKaXfDetailArr[$k]['user_id'] = $userId;
                            $userKaXfDetailArr[$k]['user_card_id'] = $v;
                        }
                        $addCardXf = $this->userQrCodeLogic->addQeCardXf($userKaXfDetailArr);//记录用户权益卡消费记录
                        if ($addCardXf) {
                            $order = [];//订单数据池
                            $order['user_id'] = $userId;
                            $order['seller_id'] = $sellerId;
                            $order['seller_service_id'] = $sellerServiceId;
                            $order['seller_staff_id'] = $staffId;
                            $order['goodsname'] = $serviceName;
                            $order['goodsprice'] = $servicePrice;
                            $order['payprice'] = $servicePrice;
                            $order['order_number'] = getOrderNumber();//获取订单号
                            $order['settlement_type'] = 1;//结算类型
                            $order['pay_status'] = 1;//支付状态
                            $order['is_comment'] = 0;//是否评价
                            $orderId = $this->userQrCodeLogic->addOrder($order);//生成订单
                            if ($orderId) {
                                $orderFlow = [];//订单流水表数据池
                                $orderFlow['order_id'] = $orderId;
                                $orderFlow['order_type'] = 2; //订单类型,2用户购买服务订单
                                $addOrderFlow = $this->userQrCodeLogic->addOrderFlow($orderFlow);//记录订单流水
                                if ($addOrderFlow) {
                                    $userXfDetail = [];//用户消费明细表数据池
                                    $userXfDetail['points'] = $servicePrice; //消费积分
                                    $userXfDetail['user_id'] = $userId;//用户id
                                    $userXfDetail['user_order_id'] = $orderId;//订单id
                                    $addUserXfDetail = $this->userQrCodeLogic->addUserXfDetail($userXfDetail);//用户消费明细
                                    if ($addUserXfDetail) {
                                        $sellMessage = [];//商家消息数据池
                                        $sellMessage['seller_id'] = $sellerId;
                                        $sellMessage['type'] = 3;//订单通知
                                        $sellMessage['seller_service_id'] = $sellerServiceId;
                                        $sellMessage['sellername'] = $sellerName;
                                        $sellMessage['servicename'] = $serviceName;
                                        $sellMessage['title'] = '订单通知';
                                        $sellMessage['content'] = $getUserInfo['nickname'] . '购买了您的' . $serviceName . '请知晓';
                                        $sellMessage['user_order_id'] = $orderId;
                                        $addSellerMessage = $this->userQrCodeLogic->addSellerMessage($sellMessage);//发送商家消息
                                        if ($addSellerMessage) {
                                            $userMessage = [];//用户消息数据池
                                            $userMessage['title'] = '扣款通知';         //通知标题
                                            $userMessage['message_type'] = 3;          //通知类型
                                            $userMessage['user_id'] = $userId;         //用户id
                                            $userMessage['user_order_id'] = $orderId;  //用户订单id
                                            $userMessage['icon'] = '';                 //icon
                                            $userMessage['create_time'] = time();
                                            $userMessage['is_read'] = 0;               //是否已读,0未读|1已读
                                            //写入消息
                                            foreach($queryCardInfo as $k=>$v){
                                                $userMessage['user_card_id'] = $v['id'];
                                                $userMessage['content'] = '尊敬的 ' . $getUserInfo['nickname'] . '您的 ' . $v['cardname'] . ' 在' . date('Y-m-d H:i:s') . '完成支付,请知晓';
                                                $addUserMessage = $this->userQrCodeLogic->addUserMessage($userMessage);//发送用户消息
                                            }
                                            if ($addUserMessage) {
                                                Db::commit();
                                                list($this->status, $this->message,$this->data) = [1, '支付成功',$orderId];
                                                return;
                                            } else {
                                                Db::rollback();
                                                list($this->status, $this->message) = [0, '支付失败'];
                                                return;
                                            }
                                        } else {
                                            Db::rollback();
                                            list($this->status, $this->message) = [0, '支付失败'];
                                            return;
                                        }
                                    } else {
                                        Db::rollback();
                                        list($this->status, $this->message) = [0, '支付失败'];
                                        return;
                                    }
                                } else {
                                    Db::rollback();
                                    list($this->status, $this->message) = [0, '支付失败'];
                                    return;
                                }
                            } else {
                                Db::rollback();
                                list($this->status, $this->message) = [0, '支付失败'];
                                return;
                            }
                        } else {
                            Db::rollback();
                            list($this->status, $this->message) = [0, '支付失败'];
                            return;
                        }
                    } else {
                        Db::rollback();
                        list($this->status, $this->message) = [0, '支付失败'];
                        return;
                    }
                } else {
                    Db::rollback();
                    list($this->status, $this->message) = [0, '支付失败11'];
                    return;
                }
            }

            if($settlementType == 2){ //如果结算方式为次卡,判断用户结算
                $monthUseCiShu = $this->monthUseCiShu($userId,$cardId);//获取用户当前次卡当月消费次数
                $totalUseCiShu = $this->totalUseCiShu($userId,$cardId);//获取用户当前次卡总消费次数
                $totalPlatformCardCiShu = $this->totalPlatformCardCiShu($cardId);//获取平台次卡总使用次数和单月可使用次数,total_value,monthly_times

                if('false' == $monthUseCiShu){
                    if(0 == $monthUseCiShu) {
                    } else {
                        list($this->status,$this->message) = [0,'支付失败'];
                        return;
                    }
                }
                if('false' == $totalUseCiShu){
                    if(0 == $totalUseCiShu){

                    } else {
                        list($this->status,$this->message) = [0,'支付失败'];
                        return;
                    }
                }
                if('false' == $totalPlatformCardCiShu){
                    if(0 == $totalUseCiShu){

                    } else {
                        list($this->status,$this->message) = [0,'支付失败'];
                        return;
                    }
                }
                if($isTimesCard == 0){
                    list($this->status,$this->message) = [0,'当前服务不支持次卡结算,请选择其他结算方式'];
                    return;
                }
                $cardRemainderCiShu = (int)$totalPlatformCardCiShu['total_value'] - (int)$totalUseCiShu;// 总剩余次数,卡总次数减去卡消费总次数等于总剩余次数
                if($cardRemainderCiShu == 0){ //剩余次数为0,不允许消费
                    list($this->status,$this->message) = [0,'当前次卡剩余次数不足'];
                    return;
                }
                if($totalPlatformCardCiShu['monthly_times'] == $monthUseCiShu){ //当月剩余次数为0,不允许消费
                    list($this->status,$this->message) = [0,'当前次卡本月次数已使用完毕'];
                    return;
                }
                if($cardRemainderCiShu < $totalPlatformCardCiShu['monthly_times']){ //如果卡总剩余次数小于单月可使用次数

                    $sYu = (int)$cardRemainderCiShu - 1; //当月剩余次数为,卡总消费次数减一
                } else {
                    $sYu = (int)$totalPlatformCardCiShu['monthly_times'] - (int)$monthUseCiShu -1;//卡总次数为单月总消费次数减去当月消费次数-1
                }
                $balanceValue = (int)$cardRemainderCiShu -1;  //用户卡总剩余使用次数
                $queryCardDetail = $this->userQrCodeLogic->queryCardDetail($cardId);//查询卡名
                $deductUserTimes = []; // 扣除用户次卡次数的数据池
                $userTimesCardId = $cardId; //用户次卡id
                $deductUserTimes['balance_value'] = $balanceValue;//用户卡总剩余次数
                $deductUserTimes['month_balance_times'] = $sYu;//用户卡当月剩余次数
                if($balanceValue == 0){ //如果用户卡总剩余次数为0,则消费状态改为1
                    $deductUserTimes['status'] = 1;//1,消费完毕
                }
                Db::startTrans();//开启事务
                $deductUserTimes = $this->userQrCodeLogic->deductUserTimes($userTimesCardId,$deductUserTimes);//扣除用户次数卡次数
                if ($deductUserTimes) { //用户消费次数扣除
                    //商家流水表:商家id,商家服务id,记录金额,进账1,创建时间
                    $incomeArr = [];//商家流水数据池
                    $incomeArr['seller_id'] = $sellerId;
                    $incomeArr['seller_service_id'] = $sellerServiceId;
                    $incomeArr['price'] = $servicePrice;
                    $incomeArr['is_balance'] = 1;
                    $addIncome = $this->userQrCodeLogic->addIncome($incomeArr);//记录商家消费流水
                    if ($addIncome) {
                        $userKaXfDetailArr = [];//用户卡消费明细数据池
                        $userKaXfDetailArr['card_type'] = 2;//次数卡
                        $userKaXfDetailArr['user_id'] = $userId;
                        $userKaXfDetailArr['user_card_id'] = $cardId;
                        $addCardXf = $this->userQrCodeLogic->addCsCardXf($userKaXfDetailArr);//记录用户次卡卡消费记录
                        if ($addCardXf) {
                            $order = [];//订单数据池
                            $order['user_id'] = $userId;
                            $order['seller_id'] = $sellerId;
                            $order['seller_service_id'] = $sellerServiceId;
                            $order['seller_staff_id'] = $staffId;
                            $order['goodsname'] = $serviceName;//服务名称
                            $order['goodsprice'] = $servicePrice;//服务价格
                            $order['payprice'] = $servicePrice; //支付金额
                            $order['order_number'] = getOrderNumber();//获取订单号
                            $order['settlement_type'] = 2;//结算类型
                            $order['pay_status'] = 1;//支付状态
                            $order['is_comment'] = 0;//是否评价
                            $orderId = $this->userQrCodeLogic->addOrder($order);//生成订单
                            if ($orderId) {
                                $orderFlow = [];//订单流水表数据池
                                $orderFlow['order_id'] = $orderId;
                                $orderFlow['order_type'] = 2; //订单类型,2用户购买服务订单
                                $addOrderFlow = $this->userQrCodeLogic->addOrderFlow($orderFlow);//记录订单流水
                                if ($addOrderFlow) {
                                    $userXfDetail = [];//用户消费明细表数据池
                                    $userXfDetail['points'] = $servicePrice; //消费积分
                                    $userXfDetail['user_id'] = $userId;//用户id
                                    $userXfDetail['user_order_id'] = $orderId;//订单id
                                    $addUserXfDetail = $this->userQrCodeLogic->addUserXfDetail($userXfDetail);//用户消费明细
                                    if ($addUserXfDetail) {
                                        $sellMessage = [];//商家消息数据池
                                        $sellMessage['seller_id'] = $sellerId;
                                        $sellMessage['type'] = 3;
                                        $sellMessage['seller_service_id'] = $sellerServiceId;
                                        $sellMessage['sellername'] = $sellerName;
                                        $sellMessage['servicename'] = $serviceName;
                                        $sellMessage['title'] = '订单通知';
                                        $sellMessage['content'] = $getUserInfo['nickname'] . '购买了您的' . $sellMessage['servicename'] . '请知晓';
                                        $sellMessage['user_order_id'] = $orderId;
                                        $addSellerMessage = $this->userQrCodeLogic->addSellerMessage($sellMessage);//发送商家消息
                                        if ($addSellerMessage) {
                                            $userMessage = [];//用户消息数据池
                                            $userMessage['title'] = '扣款通知';
                                            $userMessage['message_type'] = 3;
                                            $userMessage['user_id'] = $userId;
                                            $userMessage['user_order_id'] = $orderId;
                                            //写入消息
                                            $userMessage['content'] = '尊敬的 ' . $getUserInfo['nickname'] . '您的 ' . $queryCardDetail['cardname'] . ' 在' . date('Y-m-d H:i:s') . '完成支付,请知晓';
                                            $addUserMessage = $this->userQrCodeLogic->addUserMessage($userMessage);//发送用户消息
                                            if ($addUserMessage) {
                                                Db::commit();
                                                list($this->status, $this->message,$this->data) = [1, '支付成功',$orderId];
                                                return;
                                            } else {
                                                Db::rollback();
                                                list($this->status, $this->message) = [0, '支付失败'];
                                                return;
                                            }
                                        } else {
                                            Db::rollback();
                                            list($this->status, $this->message) = [0, '支付失败'];
                                            return;
                                        }
                                    } else {
                                        Db::rollback();
                                        list($this->status, $this->message) = [0, '支付失败'];
                                        return;
                                    }
                                } else {
                                    Db::rollback();
                                    list($this->status, $this->message) = [0, '支付失败'];
                                    return;
                                }
                            } else {
                                Db::rollback();
                                list($this->status, $this->message) = [0, '支付失败'];
                                return;
                            }
                        } else {
                            Db::rollback();
                            list($this->status, $this->message) = [0, '支付失败'];
                            return;
                        }
                    } else {
                        Db::rollback();
                        list($this->status, $this->message) = [0, '支付失败'];
                        return;
                    }
                } else {
                    Db::rollback();
                    list($this->status, $this->message) = [0, '支付失败'];
                    return;
                }
            }

        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'支付失败'];
            return;
        }
    }

}