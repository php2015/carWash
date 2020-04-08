<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/19
 * Time: 20:09
 */

namespace app\common\service;

use think\Db;
use app\common\logic\SellerQrCode as SellerQrCodeLogic;
use app\common\logic\SellerService as SellerServiceLogic;
use app\common\service\UserQrCode as UserQrCodeService;

/***
 * 商家端扫一扫结算业务类
 * Class SellerQrCode
 * @package app\common\service
 */
class SellerQrCode extends Base
{
    /**
     * 商家员工逻辑类
     * @var SellerQrCodeLogic|null
     */
    protected $sellerStaffLogic = null;

    /**
     * 商家服务逻辑类
     * @var null
     */
    protected $sellerServiceLogic = null;

    /***
     * 用户结算服务类验证是否有卡
     * @var UserQrCode|null
     */
    protected $userQrCodeService = null;

    /**
     * 构造方法
     * SellerQrCodeLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sellerQrCodeLogic = new SellerQrCodeLogic();
        $this->sellerServiceLogic = new SellerServiceLogic();
        $this->userQrCodeService = new UserQrCodeService();
    }

    /***
     * url参数byte解密
     * user_id|用户id
     * user_card_id|用户卡id
     * settlement_type|结算方式|1权益卡,2次数卡
     * @param $str
     * @return array|bool
     */
//    public function getUrlDeCode($str){
//        try{
//            $arr = array_filter(explode('.',$str));//去除空数组
//            $url = '';//准备解码的数据池
//            foreach ($arr as $key => $value) {
//                $url .= chr($value);
//            }
//            if('' == $url) return false;
//            $params = substr($url,150);
//            $getParams = array_filter(explode('&',$params));
//            $timestamp = array_filter(explode('#',$getParams[0]))[1];//时间戳
//            $Length = array_filter(explode('#',$getParams[0]));
//            $userIdStart = $getParams[1]; //userid开始位置
//            $jieSuanStart = $getParams[2]; //结算方式开始的位置
//            $cardIdStart = $getParams[3];//结算卡开始位置
//            $paramsLenArr = array_filter(explode('@',$Length[0]));
//            $userIdLen = current($paramsLenArr); //userid长度
//            $jieSuanLen = next($paramsLenArr);//结算方式的长度
//            $cardIdLen = end($paramsLenArr);//结算卡id的长度
//            $userId = mb_substr($url,$userIdStart,$userIdLen);//获取userid
//            $jiesuan = mb_substr($url,$jieSuanStart,$jieSuanLen);//获取结算方式
//            $cardId = mb_substr($url,$cardIdStart,$cardIdLen);//获取卡id
//            return ['userId'=>$userId,'jieSuan'=>$jiesuan,'cardId'=>$cardId,'timestamp'=>$timestamp];
//        }catch(\Exception $e){
//            return false;
//        }
//    }

    /***
     * 二维码参数解密
     * @param $str
     * @return array|bool
     */
//    public function getUrlDeCode($str)
//    {
//        try{
//            $decode = base64_decode($str);
//
//            $decodeArr = explode('.', $decode);
//
//            $endRound = end($decodeArr);
//
//            $byteArr = [];
//            $num = count( $decodeArr) -1;
//            foreach ($decodeArr as $k => $v) {
//                if($k < $num){
//                    array_push($byteArr,$v-$endRound);
//                }
//            }
//
//            $params = '';//准备解码的数据池
//            foreach ($byteArr as $key => $value) {
//                $params .= chr($value);
//            }
//            $paramsArr = explode('#',$params);
//            return ['userId'=>$paramsArr[0],'jieSuan'=>$paramsArr[1],'cardId'=>$paramsArr[2],'timestamp'=>$paramsArr[3]];
//        }catch(\Exception $e){
//            return false;
//        }
//    }
    /***
     * 获取商家服务
     */
    public function getAllService($sellerId)
    {
        try{
            $getAllService = $this->sellerServiceLogic->getAllService($sellerId);
            list($this->status,$this->message,$this->data) = [1,'商家服务获取成功',$getAllService];
            return;
        }catch(\Exception $e){
            list($this->status,$this->message,) = [0,'商家服务获取失败'];
            return;
        }
    }

    /***
     * 获取当前商家所有审核通过的服务
     * @param $sellerId
     */
    public function getAllInUseService($sellerId)
    {
        try{
            $getAllService = $this->sellerServiceLogic->getAllInUseService($sellerId);
            list($this->status,$this->message,$this->data) = [1,'商家审核通过服务获取成功',$getAllService];
            return;
        }catch(\Exception $e){
            list($this->status,$this->message,) = [0,'商家审核通过服务获取失败'];
            return;
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
            return $this->sellerQrCodeLogic->getUserInfo($userId);
        }catch(\Exception $e){
            return false;
        }
    }
    /***
     * 查询用户余额
     * @param $userId
     * @return array|bool|false|\PDOStatement|string|\think\Model
     */
    public function getUserCardInfo($userId)
    {
        try{
            return $this->sellerQrCodeLogic->getUserCardInfo($userId);
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
            return $this->sellerQrCodeLogic->monthUseCiShu($params);
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
            return $this->sellerQrCodeLogic->totalUseCiShu($params);
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
            return $this->sellerQrCodeLogic->totalPlatformCardCiShu($cardId);
        }catch(\Exception $e){
            return 'false';
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
            return $this->sellerQrCodeLogic->ServiceIsTimesCard($sellerId,$serviceId);
        }catch(\Exception $e){
            return false;
        }
    }

    /***
     * 判断当前用户是否有卡
     * @param $params
     */
    public function isOwnCard($params)
    {
        try{
            $getQrCodeData = $this->getUrlDeCode($params['qr_data']);//解析二维码数据
            if(false == $getQrCodeData){
                list($this->status,$this->message) = [0,'二维码信息获取失败'];
                return;
            }
            if(time() - ((int)$getQrCodeData['timestamp']) > config('app.qrCode_expire_time')){//配置文件中配置的时间
                list($this->status,$this->message) = [0,'二维码已失效'];
                return;
            }
            //判断当前用户是否有卡,返回数组qy,ck|1有,2无
            $userId = [];
            $userId['user_id'] = $getQrCodeData['userId'];
            $queryOwnCard = $this->userQrCodeService->queryOwnCard($userId);
            if(false !== $queryOwnCard){
                list($this->status,$this->message,$this->data) = [1,'用户卡信息获取成功',$queryOwnCard];
                return;
            }
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'用户卡信息获取失败'];
            return;
        }
    }
    /***
     * 扫一扫权益卡/次卡收款流程
     * @param $params
     */
    public function checkoutProcess($params)
    {

        try{
            $getQrCodeData = $this->getUrlDeCode($params['qr_data']);//解析二维码数据
            if(false == $getQrCodeData){
                list($this->status,$this->message) = [0,'二维码信息获取失败'];
                return;
            }
            if(time() - ((int)$getQrCodeData['timestamp']) > config('app.qrCode_expire_time')){//配置文件中配置的时间
                list($this->status,$this->message) = [0,'二维码已失效'];
                return;
            }
            //解析二维码数据重新赋值
            $params['user_id'] = $getQrCodeData['userId']; //用户id
            $params['settlement_type'] = $getQrCodeData['jieSuan']; //结算类型
            $params['user_card_id'] = $getQrCodeData['cardId']; //用户卡id


            $getUserCardInfo = $this->getUserCardInfo($params['user_id']);//获取用户卡信息,权益卡无user_card_id

            $serviceIsTimesCard = $this->ServiceIsTimesCard($params['seller_id'],$params['seller_service_id']);//获取当前服务信息
            $params['servicename'] = $serviceIsTimesCard['servicename']; //查询商家服务表获取服务名称
            $params['serviceprice'] = $serviceIsTimesCard['serviceprice'];//查询商家服务表获取服务价格
            $params['is_timescard'] = $serviceIsTimesCard['is_timescard'];//查询商家服务表获取是否支持次卡结算
            $getUserInfo = $this->getUserInfo($getQrCodeData['userId']);//获取用户信息
            if(false == $getUserInfo || empty($getUserInfo)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
            if(false == $getUserCardInfo || empty($getUserCardInfo)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
            if(false == $serviceIsTimesCard || empty($serviceIsTimesCard)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }

            if($params['settlement_type'] == 1) { //权益卡结算
                //循环查询当前用户可使用权益卡逻辑,开始
                //卡类型,用户id,查询出当前用户所有可使用的权益卡
                $canUseQyCard = $this->sellerQrCodeLogic->canUseQyCard($params['user_id']);
                if(empty($canUseQyCard)){ //如果没有可使用的权益卡
                    list($this->status,$this->message) = [0,'支付失败'];
                    return;
                }
                //如果结算方式为权益卡
                //按时间正序查询当前用户所有权益卡,从第一张卡开始扣款
                //如果余额不足,按照购买时间正序查询,直到积分扣除完毕为止,扣款过程需要记录用户卡id,扣除后的余额
                //如果单张卡已扣完,则余额为0,如果积分扣除完毕,变更卡状态为已消费完毕
                //$takeMoney = 200; //需要支付的积分
                $takeMoney = $params['serviceprice']; //需要支付的积分,服务价格
                $tookMoney = 0; //已经扣的积分
                $takeResult = [];//准备批量更新权益卡数值的数据池
                $qyTotal = 0;
                foreach ($canUseQyCard as &$val) {
                    $qyTotal += $val['balance_value'];
                    if ($val['balance_value'] > 0 && $tookMoney < $takeMoney) {
                        $value = $val['balance_value'];
                        // $takeMoney-$tookMoney 还需要扣的金额
                        $take = ($value < ($takeMoney - $tookMoney)) ? $value : ($takeMoney - $tookMoney); //扣的积分
                        // $val['balance_value'] = $val['balance_value'] - $value;
                        $tookMoney += $take;
                        if ($val['balance_value'] > $take) { //根据扣除的值修改状态
                            $takeResult[] = ['id' => $val['id'], 'balance_value' => $val['balance_value'] - $take, 'status' => 0];  //若积分扣除完毕,状态为0
                        } else {
                            $takeResult[] = ['id' => $val['id'], 'balance_value' => $val['balance_value'] - $take, 'status' => 1]; //若有积分剩余,状态为1
                        }
                    }
                    //如果已扣满金额,则退出循环
                    if ($tookMoney == $takeMoney) {
                        break;
                    }
                }
                if ($qyTotal < $params['serviceprice']) { //如果用户当前的所有权益卡的权益值小于服务价格,return false
                    list($this->status, $this->message) = [0, '用户余额不足'];
                    return;
                }
                //循环查询当前用户可使用权益卡逻辑,结束
                //权益卡开始结算
                //0扣除用户权益卡积分
                //1商家流水表
                //2用户卡消费记录表
                //3订单表
                //4订单流水表
                //5用户消费明细表
                //6用户卡表当月剩余次数更改,权益卡不需要此项
                //7商家消息表
                //8循环写入用户消息表
                Db::startTrans();//开启事务
                //商家流水表:商家id,商家服务id,记录金额,进账1,创建时间
                //根据用户id查询卡名/卡信息
                $userCardId = [];
                foreach($takeResult as $k=>$v){
                    $userCardId[] = $v['id']; //获取用户卡表id
                }
                $queryCardInfo = $this->sellerQrCodeLogic->queryCardInfo($userCardId);//查询卡名
                //扣除用户卡的积分
                $deductUserIntegral = $this->sellerQrCodeLogic->deductUserIntegral($takeResult);//扣除用户卡积分
                if ($deductUserIntegral) { //用户消费积分扣除
                    $incomeArr = [];//商家流水数据池
                    $incomeArr['seller_id'] = $params['seller_id'];
                    $incomeArr['seller_service_id'] = $params['seller_service_id'];
                    $incomeArr['price'] = $params['serviceprice'];
                    $incomeArr['is_balance'] = 1;
                    $addIncome = $this->sellerQrCodeLogic->addIncome($incomeArr);//记录商家消费流水
                    if ($addIncome) {
                        $userKaXfDetailArr = [];//用户卡消费明细数据池
                        foreach($userCardId as $k=>$v){
                            $userKaXfDetailArr[$k]['card_type'] = 1;//权益卡
                            $userKaXfDetailArr[$k]['user_id'] = $params['user_id'];
                            $userKaXfDetailArr[$k]['user_card_id'] = $v;
                        }
                        $addCardXf = $this->sellerQrCodeLogic->addQeCardXf($userKaXfDetailArr);//记录用户权益卡消费记录
                        if ($addCardXf) {
                            $order = [];//订单数据池
                            $order['user_id'] = $params['user_id'];
                            $order['seller_id'] = $params['seller_id'];
                            $order['seller_service_id'] = $params['seller_service_id'];
                            $order['seller_staff_id'] = $params['seller_staff_id'];
                            $order['goodsname'] = $params['servicename'];
                            $order['goodsprice'] = $params['serviceprice'];
                            $order['payprice'] = $params['serviceprice'];
                            $order['order_number'] = getOrderNumber();//获取订单号
                            $order['settlement_type'] = 1;//结算类型
                            $order['pay_status'] = 1;//支付状态
                            $order['is_comment'] = 0;//是否评价
                            $orderId = $this->sellerQrCodeLogic->addOrder($order);//生成订单
                            if ($orderId) {
                                $orderFlow = [];//订单流水表数据池
                                $orderFlow['order_id'] = $orderId;
                                $orderFlow['order_type'] = 2; //订单类型,2用户购买服务订单
                                $addOrderFlow = $this->sellerQrCodeLogic->addOrderFlow($orderFlow);//记录订单流水
                                if ($addOrderFlow) {
                                    $userXfDetail = [];//用户消费明细表数据池
                                    $userXfDetail['points'] = $params['serviceprice']; //消费积分
                                    $userXfDetail['user_id'] = $params['user_id'];//用户id
                                    $userXfDetail['user_order_id'] = $orderId;//订单id
                                    $addUserXfDetail = $this->sellerQrCodeLogic->addUserXfDetail($userXfDetail);//用户消费明细
                                    if ($addUserXfDetail) {
                                        $sellMessage = [];//商家消息数据池
                                        $sellMessage['seller_id'] = $params['seller_id'];
                                        $sellMessage['type'] = 3;//订单通知
                                        $sellMessage['seller_service_id'] = $params['seller_service_id'];
                                        $sellMessage['sellername'] = $params['sellername'];
                                        $sellMessage['servicename'] = $params['servicename'];
                                        $sellMessage['title'] = '订单通知';
                                        $sellMessage['content'] = $getUserInfo['nickname'] . '购买了您的' . $sellMessage['servicename'] . '请知晓';
                                        $sellMessage['user_order_id'] = $orderId;
                                        $addSellerMessage = $this->sellerQrCodeLogic->addSellerMessage($sellMessage);//发送商家消息
                                        if ($addSellerMessage) {
                                            $userMessage = [];//用户消息数据池
                                            $userMessage['title'] = '扣款通知';
                                            $userMessage['message_type'] = 3;
                                            $userMessage['user_id'] = $params['user_id'];
                                            $userMessage['user_order_id'] = $orderId;
                                            $userMessage['icon'] = '';                 //icon
                                            $userMessage['create_time'] = time();
                                            $userMessage['is_read'] = 0;               //是否已读,0未读|1已读
                                            //写入消息
                                            foreach($queryCardInfo as $k=>$v){
                                                $userMessage['user_card_id'] = $v['id'];
                                                $userMessage['content'] = '尊敬的 ' . $getUserInfo['nickname'] . '您的 ' . $v['cardname'] . ' 在' . date('Y-m-d H:i:s') . '完成支付,请知晓';
                                                $addUserMessage = $this->sellerQrCodeLogic->addUserMessage($userMessage);//发送用户消息
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
                    list($this->status, $this->message) = [0, '支付失败'];
                    return;
                }
            }
            if($params['settlement_type'] == 2){ //如果结算方式为次卡,判断用户结算
                $monthUseCiShu = $this->monthUseCiShu($params['user_id'],$params['user_card_id']);//获取用户当前次卡当月消费次数
                $totalUseCiShu = $this->totalUseCiShu($params['user_id'],$params['user_card_id']);//获取用户当前次卡总消费次数
                $totalPlatformCardCiShu = $this->totalPlatformCardCiShu($params['user_card_id']);//获取平台次卡总使用次数和单月可使用次数,total_value,monthly_times

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
                //如果用户结算使用的是次卡,而商家不支持次卡结算
                //如果当前次卡总消费次数大于平台次卡总使用次数,不允许结算
                //如果当前月消费次数大于当月可使用次数,不允许结算
                if($serviceIsTimesCard['is_timescard'] == 0){
                    list($this->status,$this->message) = [0,'当前服务不支持次卡结算,请选择其他结算方式'];
                    return;
                }
                if($totalUseCiShu > $totalPlatformCardCiShu['total_value']){
                    list($this->status,$this->message) = [0,'当前次卡总次数已消费完毕,请选择其他结算方式'];
                    return;
                }
                if($monthUseCiShu >= $totalPlatformCardCiShu['monthly_times']){//因为后面做了减一操作
                    list($this->status,$this->message) = [0,'当前次卡当月次数已消费完毕,请选择其他结算方式'];
                    return;
                }
                //1.计算当月剩余使用次数,2卡总消费次数,3当月消费次数,4卡总次数减一,5当月可使用次数减一,6如果剩余次数小于单月可使用次数,则当月可使用次数为剩余次数
                //$totalPlatformCardCiShu['monthly_times'];
                //0减去用户当月剩余使用次数
                //1商家流水表
                //2用户卡消费记录表
                //3订单表
                //4订单流水表
                //5用户消费明细表
                //6用户卡表当月剩余次数更改,权益卡不需要此项
                //7商家消息表
                //8循环写入用户消息表
                //$monthUseCiShu;  //当月消费次数
                //$totalUseCiShu; //总消费次数
                //$totalPlatformCardCiShu;//平台卡总使用次数和单月可使用次数
                $cardRemainderCiShu = (int)$totalPlatformCardCiShu['total_value'] - (int)$totalUseCiShu;// 总剩余次数,卡总次数减去卡消费总次数等于总剩余次数
                if($cardRemainderCiShu == 0){ //剩余次数为0,不允许消费
                    list($this->status,$this->message) = [0,'当前次卡不能使用'];
                    return;
                }
                if($totalPlatformCardCiShu['monthly_times'] == $monthUseCiShu){ //当月剩余次数为0,不允许消费
                    list($this->status,$this->message) = [0,'当前次卡不能使用'];
                    return;
                }
                if($cardRemainderCiShu < $totalPlatformCardCiShu['monthly_times']){ //如果卡总剩余次数小于单月可使用次数

                    $sYu = (int)$cardRemainderCiShu - 1; //当月剩余次数为,卡总消费次数减一
                } else {
                    $sYu = (int)$totalPlatformCardCiShu['monthly_times'] - (int)$monthUseCiShu -1;//卡总次数为单月总消费次数减去当月消费次数-1
                }
                $balanceValue = (int)$cardRemainderCiShu -1;  //用户卡总剩余使用次数

                $queryCardDetail = $this->sellerQrCodeLogic->queryCardDetail($params['user_card_id']);//查询卡名
                $deductUserTimes = []; // 扣除用户次卡次数的数据池
                $userTimesCardId = $params['user_card_id']; //用户次卡id
                $deductUserTimes['balance_value'] = $balanceValue;//用户卡总剩余次数
                $deductUserTimes['month_balance_times'] = $sYu;//用户卡当月剩余次数
                if($balanceValue == 0){ //如果用户卡总剩余次数为0,则消费状态改为1
                    $deductUserTimes['status'] = 1;//1,消费完毕
                }
                Db::startTrans();//开启事务
                $deductUserTimes = $this->sellerQrCodeLogic->deductUserTimes($userTimesCardId,$deductUserTimes);//扣除用户次数卡次数
                if ($deductUserTimes) { //用户消费次数扣除
                    //商家流水表:商家id,商家服务id,记录金额,进账1,创建时间
                    $incomeArr = [];//商家流水数据池
                    $incomeArr['seller_id'] = $params['seller_id'];
                    $incomeArr['seller_service_id'] = $params['seller_service_id'];
                    $incomeArr['price'] = $params['serviceprice'];
                    $incomeArr['is_balance'] = 1;
                    $addIncome = $this->sellerQrCodeLogic->addIncome($incomeArr);//记录商家消费流水
                    if ($addIncome) {
                        $userKaXfDetailArr = [];//用户卡消费明细数据池
                        $userKaXfDetailArr['card_type'] = 2;//次数卡
                        $userKaXfDetailArr['user_id'] = $params['user_id'];
                        $userKaXfDetailArr['user_card_id'] = $params['user_card_id'];
                        $addCardXf = $this->sellerQrCodeLogic->addCsCardXf($userKaXfDetailArr);//记录用户次卡卡消费记录
                        if ($addCardXf) {
                            $order = [];//订单数据池
                            $order['user_id'] = $params['user_id'];
                            $order['seller_id'] = $params['seller_id'];
                            $order['seller_service_id'] = $params['seller_service_id'];
                            $order['seller_staff_id'] = $params['seller_staff_id'];
                            $order['goodsname'] = $params['servicename'];//服务名称
                            $order['goodsprice'] = $params['serviceprice'];//服务价格
                            $order['payprice'] = $params['serviceprice']; //支付金额
                            $order['order_number'] = getOrderNumber();//获取订单号
                            $order['settlement_type'] = 2;//结算类型
                            $order['pay_status'] = 1;//支付状态
                            $order['is_comment'] = 0;//是否评价
                            $orderId = $this->sellerQrCodeLogic->addOrder($order);//生成订单
                            if ($orderId) {
                                $orderFlow = [];//订单流水表数据池
                                $orderFlow['order_id'] = $orderId;
                                $orderFlow['order_type'] = 2; //订单类型,2用户购买服务订单
                                $addOrderFlow = $this->sellerQrCodeLogic->addOrderFlow($orderFlow);//记录订单流水
                                if ($addOrderFlow) {
                                    $userXfDetail = [];//用户消费明细表数据池
                                    $userXfDetail['points'] = $params['serviceprice']; //消费积分
                                    $userXfDetail['user_id'] = $params['user_id'];//用户id
                                    $userXfDetail['user_order_id'] = $orderId;//订单id
                                    $addUserXfDetail = $this->sellerQrCodeLogic->addUserXfDetail($userXfDetail);//用户消费明细
                                    if ($addUserXfDetail) {
                                        $sellMessage = [];//商家消息数据池
                                        $sellMessage['seller_id'] = $params['seller_id'];
                                        $sellMessage['type'] = 3;
                                        $sellMessage['seller_service_id'] = $params['seller_service_id'];
                                        $sellMessage['sellername'] = $params['sellername'];
                                        $sellMessage['servicename'] = $params['servicename'];
                                        $sellMessage['title'] = '订单通知';
                                        $sellMessage['content'] = $getUserInfo['nickname'] . '购买了您的' . $sellMessage['servicename'] . '请知晓';
                                        $sellMessage['user_order_id'] = $orderId;
                                        $addSellerMessage = $this->sellerQrCodeLogic->addSellerMessage($sellMessage);//发送商家消息
                                        if ($addSellerMessage) {
                                            $userMessage = [];//用户消息数据池
                                            $userMessage['title'] = '扣款通知';
                                            $userMessage['message_type'] = 3;
                                            $userMessage['user_id'] = $params['user_id'];
                                            $userMessage['user_order_id'] = $orderId;
                                            //写入消息
                                            $userMessage['content'] = '尊敬的 ' . $getUserInfo['nickname'] . '您的 ' . $queryCardDetail['cardname'] . ' 在' . date('Y-m-d H:i:s') . '完成支付,请知晓';
                                            $addUserMessage = $this->sellerQrCodeLogic->addUserMessage($userMessage);//发送用户消息
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
        }
    }
}