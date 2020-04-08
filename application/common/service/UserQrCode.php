<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/29
 * Time: 10:32
 */

namespace app\common\service;

use think\Db;
use think\Cache;
use think\helper\Hash;
use app\common\logic\User as UserLogic;
use app\common\logic\UserQrCode as UserQrCodeLogic;

/***
 * 用户扫码业务类
 * Class UserQrCode
 * @package app\common\service
 */
class UserQrCode extends Base
{
    /***
     * 用户扫码逻辑类
     * @var null
     */
    protected $userQrCodeLogic = null;

    /***
     * 用户逻辑类
     * @var null
     */
    protected $userLogic = null;
    /**
     * 构造方法
     * SellerQrCodeLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userLogic = new UserLogic();
        $this->userQrCodeLogic = new UserQrCodeLogic();
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
//
//            $timestamp = array_filter(explode('#',$getParams[0]))[1];//时间戳
//
//            $Length = array_filter(explode('#',$getParams[0]));
//            $staffIdStart = $getParams[1]; //商家id开始位置
//
//
//            $sellerIdStart = $getParams[2]; //员工id开始的位置
//
//            $paramsLenArr = array_filter(explode('@',$Length[0]));
//            $staffIdLen = current($paramsLenArr); //userid长度
//
//            $sellerIdLen = next($paramsLenArr);//结算方式的长度
//
//            $staffId = mb_substr($url,$staffIdStart,$staffIdLen);//获取员工id
//
//            $sellerId = mb_substr($url,$sellerIdStart,$sellerIdLen);//获取商家id
//
//            return ['sellerId'=>$sellerId,'staffId'=>$staffId,'timestamp'=>$timestamp];
//        }catch(\Exception $e){
//            return false;
//        }
//    }

    /***
     * url 参数解密
     * @param $str
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
//
//            $paramsArr = explode('#',$params);
//            return ['sellerId'=>$paramsArr[1],'staffId'=>$paramsArr[0],'timestamp'=>$paramsArr[2]];
//        }catch(\Exception $e){
//            return false;
//        }
//    }
    /***
     * 用户端扫码获取商家信息
     */
    public function getBizInfo($params)
    {
        try{
            $getQrCodeData = $this->getUrlDeCode($params['qr_data']);//解析二维码数据
            if(false == $getQrCodeData){
                list($this->status,$this->message) = [0,'二维码信息获取失败'];
                return;
            }
            $params['seller_id'] = $getQrCodeData['sellerId'];
            $params['staff_id'] = $getQrCodeData['staffId'];
            $getBizInfo = $this->userQrCodeLogic->getBizInfo($params);
            if ($getBizInfo['is_review'] !== 1){
                list($this->status,$this->message,) = [0,'该商家未加盟'];
                return;
            }
            if ($getBizInfo['is_disabled'] == 1){
                list($this->status,$this->message,) = [0,'该商家已下架'];
                return;
            }
            list($this->status,$this->message,$this->data) = [1,'商家信息获取成功',[
                'id'          => $getBizInfo['id'],
                'sellername'  => $getBizInfo['sellername'],
                'seller_pic3' => config('token.web_site_domain') . get_file_path($getBizInfo['seller_pic3']),
                'address'     => $getBizInfo['address'],
            ]];
            return;
        }catch(\Exception $e){
            list($this->status,$this->message,) = [0,'商家信息获取失败'];
            return;
        }
    }

    /***
     * 获取当前商家所有审核通过的服务
     * @param $sellerId
     */
    public function getAllInUseService($params)
    {
        try{
            $getQrCodeData = $this->getUrlDeCode($params['qr_data']);//解析二维码数据
            if(false == $getQrCodeData){
                list($this->status,$this->message) = [0,'二维码信息获取失败'];
                return;
            }
            $getAllService = $this->userQrCodeLogic->getAllInUseService($getQrCodeData['sellerId']);
            list($this->status,$this->message,$this->data) = [1,'商家审核通过服务获取成功',$getAllService];
            return;
        }catch(\Exception $e){
            list($this->status,$this->message,) = [0,'商家审核通过服务获取失败'];
            return;
        }
    }

    /***
     * 用户扫码获取当前用户所有的次数卡,列表显示用户当前拥有总次数大于0/当月剩余次数大于0的次数卡
     * @param $params
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSettlementCard($params)
    {
        try{
            $getSettlementCard = $this->userQrCodeLogic->getSettlementCard($params);
            if(empty($getSettlementCard)){
                list($this->status,$this->message,$this->data) = [1,'您当前无可使用次卡,请前往购买',[]];
                return;
            }
            $cardArr = [];
            foreach($getSettlementCard as $k=>$v){
                $cardArr[$k]['id'] = $v['id'];                  //卡id
                $cardArr[$k]['cardname'] = $v['cardname'];      //卡名称
                $cardArr[$k]['card_type'] = $v['card_type'];    //卡类型

                //if($v['balance_value'] == 0){               //如果用户卡剩余使用次数为0
                //    $cardArr[$k]['is_use'] = 0;             //is_use为0,0不可使用|1可使用
                //    $cardArr[$k]['descr'] = '次数不足';      //is_use为0,0不可使用|1可使用
                //} else {                                    //如果用户卡剩余次数不为0
                //    if($v['monthRestTimes'] == 0){          //用户当月剩余次数为0
                //        $cardArr[$k]['is_use'] = 0;         //is_use为0,0不可使用|1可使用
                //        $cardArr[$k]['descr'] = '当月使用次数不足';//is_use为0,0不可使用|1可使用
                //    } else {                                //用户当月剩余次数不为0
                //        $cardArr[$k]['is_use'] = 1;         //is_use为0,0不可使用|1可使用
                //        $cardArr[$k]['descr'] = '您本月还可以使用'.$v['monthRestTimes'].'次';
                //    }
                //}

                $v['monthRestTimes'] = $v['monthly_times'] - $v['useInMonth'];
                if($v['balance_value'] < $v['monthRestTimes']){
                    if($v['balance_value'] <= 0){
                        $cardArr[$k]['is_use'] = 0;
                        $cardArr[$k]['descr'] = '当月使用次数不足';
                    } else {
                        $cardArr[$k]['is_use'] = 1;
                        $cardArr[$k]['descr'] = '您本月还可以使用'.$v['balance_value'].'次';
                    }
                } else {
                    $cardArr[$k]['monthRestTimes'] = $v['monthly_times'] - $v['useInMonth'];
                    if($cardArr[$k]['monthRestTimes'] == 0){
                        $cardArr[$k]['is_use'] = 0;
                        $cardArr[$k]['descr'] = '当月使用次数不足';
                    } else {
                        $cardArr[$k]['is_use'] = 1;
                        $cardArr[$k]['descr'] = '您本月还可以使用'.($v['monthly_times'] - $v['useInMonth']).'次';
                    }
                }

            }
            list($this->status,$this->message,$this->data) = [1,'卡列表获取成功',$cardArr];
            return;
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'卡列表获取失败'];
            return;
        }
    }

    /***
     * 判断用户是否有可使用的卡
     * @param $params
     */
    public function isOwnCard($params)
    {
        try{
            $queryOwnCard = $this->queryOwnCard($params);
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
     * 判断用户是否有可使用的卡
     * qy  ck
     * 1有 2无
     * @param $params
     * @return array|bool
     */
    public function queryOwnCard($params)
    {
        try{
            $OwnCsCard = $this->userQrCodeLogic->isOwnCsCard($params); //次卡
            $isOwnQeCard = $this->userQrCodeLogic->isOwnQeCard($params); //权益卡
            $isOwnCsCard = [];//次卡数据池,计算剩余次数,单月可使用次数等
            foreach ($OwnCsCard as $k=>$v){
                $isOwnCsCard[$k]['id'] = $v['id'];
                $isOwnCsCard[$k]['balance_value'] = $v['balance_value'];
                $isOwnCsCard[$k]['monthly_times'] = $v['monthly_times'];
                $isOwnCsCard[$k]['card_type'] = $v['card_type'];
                $isOwnCsCard[$k]['cardname'] = $v['cardname'];
                //$isOwnCsCard[$k]['useInMonth'] = $v['useInMonth'];

                //单月剩余使用次数
                $isOwnCsCard[$k]['monthRestTimes'] = $v['monthly_times'] - $v['useInMonth'];

                if($v['balance_value'] < $isOwnCsCard[$k]['monthRestTimes']){
                    if($v['balance_value'] <= 0){
                        $isOwnCsCard[$k]['monthRestTimes'] = 0;
                    } else {
                        $isOwnCsCard[$k]['monthRestTimes'] = $v['balance_value'];
                    }
                } else {
                    $isOwnCsCard[$k]['monthRestTimes'] = $v['monthly_times'] - $v['useInMonth'];
                }
                //卡种余额
                $isOwnCsCard[$k]['balance_value'] = $v['balance_value'];
            }
            if(empty($isOwnCsCard) && empty($isOwnQeCard)){ //如果权益卡与次卡都为空
                $qy = 2;//无
                $ck = 2;//无
            } elseif (!empty($isOwnCsCard) && empty($isOwnQeCard)){ //如果次数卡不为空,判断是否有可用的次数卡
                $csArr = [];
                //如果卡总使用次数不为0
                //并且当月可使用次数大于0
                //进行记录,即有卡,非空
                foreach($isOwnCsCard as $k=>$v){
                    if($v['balance_value'] > 0 && $v['monthRestTimes']>0){
                        $csArr[$k]['is_use'] = 1;
                    }
                }
                if(empty($csArr)){
                    $qy = 2;
                    $ck = 2;
                } else {   //如果数组不为空,则说明有卡
                    $qy = 2;
                    $ck = 1;
                }
            } elseif (empty($isOwnCsCard) && !empty($isOwnQeCard)){ //如果权益卡不为空,判断是否有可用的权益卡
                $qeArr = [];
                foreach($isOwnQeCard as $k=>$v){
                    if($v['balance_value'] !== 0){
                        $qeArr[$k]['is_use'] = 1;
                    }
                }
                if(empty($qeArr)){
                    $qy = 2;
                    $ck = 2;
                } else {  //如果数组不为空,则说明有卡
                    $qy = 1;
                    $ck = 2;
                }
            } elseif (!empty($isOwnCsCard) && !empty($isOwnQeCard)){ //如果次数卡权益卡都不为空,判断是否有可用的卡
                $qeArr = [];//权益数据池
                $csArr = [];//次卡数据池
                foreach($isOwnQeCard as $k=>$v){
                    if($v['balance_value'] !== 0){
                        $qeArr[$k]['is_use'] = 1;
                    }
                }
                foreach($isOwnCsCard as $k=>$v){
                    if($v['balance_value'] > 0 && $v['monthRestTimes']>0){
                        $csArr[$k]['is_use'] = 1;
                    }
                }
                if(empty($qeArr) && empty($csArr)){
                    $qy = 2;
                    $ck = 2;
                } elseif (!empty($qeArr) && empty($csArr)){
                    $qy = 1;
                    $ck = 2;
                }elseif (empty($qeArr) && !empty($csArr)){
                    $qy = 2;
                    $ck = 1;
                }elseif (!empty($qeArr) && !empty($csArr)){
                    $qy = 1;
                    $ck = 1;
                }
            }
            return ['qy'=>$qy,'ck'=>$ck];
        }catch(\Exception $e){
            return false;
        }
    }
    /***
     * 验证支付密码
     * @param $params
     */
    public function validatePayPwd($params)
    {
        try{
            $queryOldPayPwd = $this->userLogic->queryOldPayPwd($params);
            $mobile = $queryOldPayPwd['mobile'];
            $nowPayTime = cache($mobile . '_nowPayTime') ? cache($mobile . '_nowPayTime') : '';
            $expPayTime = cache($mobile . '_expPayTime') ? cache($mobile . '_expPayTime') : '';
            if (!empty($nowPayTime) && !empty($expPayTime)) {
                if ($nowPayTime < $expPayTime) {
                    if (cache($mobile . '_errPayPwd') == config('app.payMent_input_times')) {
                        list($this->status,$this->message) = [config('app.input_paypwd_status'),'您的交易密码已经绑定,请用手机号找回'];
                        return;
                    } else {
                        $this->matchPayPwd($params['pay_pwd'],$queryOldPayPwd['paypwd'],$mobile);
                    }
                } else {
                    $this->matchPayPwd($params['pay_pwd'],$queryOldPayPwd['paypwd'],$mobile);
                }
            } else {
                $this->matchPayPwd($params['pay_pwd'],$queryOldPayPwd['paypwd'],$mobile);
            }
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'支付密码验证失败'];
            return;
        }
    }

    /***
     * 匹配支付密码
     * @param $payPwd
     * @param $orderPayPwd
     * @param $mobile
     */
    public function matchPayPwd($payPwd,$orderPayPwd,$mobile)
    {
        if (!Hash::check((string)$payPwd, $orderPayPwd)) {
            cache($mobile . '_nowPayTime', time(), config('app.payMent_expire_time'));
            cache($mobile . '_expPayTime', strtotime("+3 minute"), config('app.payMent_expire_time'));
            if(cache::has($mobile . '_errPayPwd')){
                if(cache($mobile . '_errPayPwd') > config('app.errPayPwd_input_times')){
                    cache($mobile . '_errPayPwd',config('app.errPayPwd_input_times'),config('app.payMent_expire_time'));
                }
            } else {
                cache($mobile . '_errPayPwd',0,config('app.payMent_expire_time'));
            }
            Cache::inc($mobile .'_errPayPwd'); //设置值自增
            $incNum = config('app.payMent_input_times') - cache($mobile . '_errPayPwd');//剩余输入次数
            if($incNum > 0){
                list($this->status, $this->message) = [0, '输入密码错误,您还可输入'. $incNum .'次'];
                return;
            } else {
                list($this->status,$this->message) = [config('app.input_paypwd_status'),'您的交易密码已经绑定,请用手机号找回'];
                return;
            }
        } else { //验证成功,则清除缓存
            cache($mobile . '_nowPayTime', NULL);
            cache($mobile . '_expPayTime', NULL);
            cache($mobile . '_errPayPwd', NULL);
            list($this->status,$this->message) = [1,'支付密码验证成功'];
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
            return $this->userQrCodeLogic->getUserInfo($userId);
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
            return $this->userQrCodeLogic->getUserCardInfo($userId);
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
     * 用户扫商家二维码付款
     * @param $params
     */
    public function userPayMent($params)
    {
        try{
            $getQrCodeData = $this->getUrlDeCode($params['qr_data']);//解析二维码数据
            if(false == $getQrCodeData){
                list($this->status,$this->message) = [0,'二维码信息获取失败'];
                return;
            }
            //解析二维码数据重新赋值
            $sellerId = $getQrCodeData['sellerId'];             //商家id
            $staffId = $getQrCodeData['staffId'];               //商家员工id
            $sellerServiceId = $params['seller_service_id'];    //商家服务id
            $userId = $params['user_id'];                       //用户id
            $cardId = $params['card_id'];                       //卡id
            $sellerName = $params['sellername'];                //商家名称
            $settlementType = $params['settlement_type'];       //结算方式
            //$getUserCardInfo = $this->getUserCardInfo($userId); //获取用户卡信息,权益卡无user_card_id
            $serviceIsTimesCard = $this->ServiceIsTimesCard($sellerId,$sellerServiceId);//获取当前服务信息
            $getUserInfo = $this->getUserInfo($userId);         //获取用户信息
            if(false == $getUserInfo || empty($getUserInfo)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
            if(false == $serviceIsTimesCard || empty($serviceIsTimesCard)){
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
            $serviceName = $serviceIsTimesCard['servicename']; //查询商家服务表获取服务名称
            $servicePrice = $serviceIsTimesCard['serviceprice'];//查询商家服务表获取服务价格
            $isTimesCard = $serviceIsTimesCard['is_timescard'];//查询商家服务表获取是否支持次卡结算

            if($settlementType == 1) {
                //1权益卡结算,2循环查询当前用户可使用权益卡逻辑,开始,3卡类型,用户id,查询出当前用户所有可使用的权益卡
                $canUseQyCard = $this->userQrCodeLogic->canUseQyCard($userId);
                if(empty($canUseQyCard)){ //如果没有可使用的权益卡
                    list($this->status,$this->message) = [0,'支付失败'];
                    return;
                }
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
                                            $userMessage['title'] = '扣款通知';
                                            $userMessage['message_type'] = 3;
                                            $userMessage['user_id'] = $userId;
                                            $userMessage['user_order_id'] = $orderId;
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
                    list($this->status, $this->message) = [0, '支付失败'];
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