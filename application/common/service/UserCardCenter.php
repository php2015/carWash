<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/27
 * Time: 11:30
 */

namespace app\common\service;

use think\Db;
use app\common\logic\UserCardCenter as UserCardCenterLogic;
class UserCardCenter extends Base
{
    protected $userLogic = null;

    /**
     * 构造方法
     * UserLogic constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userCardCenterLogic = new UserCardCenterLogic();
    }

    /***
     * 卡种类别列表
     * @param $params
     */
    public function cardCategories($params)
    {
        try{
            $cardCategories = $this->userCardCenterLogic->cardCategories($params);
            $returnArr = [];//返回数据数据池
            if($params['card_type'] == 1){ //权益卡
                foreach($cardCategories as $k=>$v){
                    $returnArr[$k]['id'] = $v['id'];
                    $returnArr[$k]['cardname'] = $v['cardname'];            //卡名
                    $returnArr[$k]['period'] = $v['period'];                //使用周期
                    $returnArr[$k]['card_type'] = $v['card_type'];          //卡类型
                    $returnArr[$k]['total_value'] = $v['total_value'];      //权益值数量
                    $returnArr[$k]['cash_pay_value'] = $v['cash_pay_value'];//现金价值
                    $returnArr[$k]['service'] = '全部服务';                  //支持服务
                }
            } elseif ($params['card_type'] == 2){ //次数卡
                foreach($cardCategories as $k=>$v){
                    $returnArr[$k]['id'] = $v['id'];
                    $returnArr[$k]['cardname'] = $v['cardname'];            //卡名
                    $returnArr[$k]['period'] = $v['period'];                //使用期限
                    $returnArr[$k]['card_type'] = $v['card_type'];          //卡类型
                    $returnArr[$k]['monthly_times'] = $v['monthly_times'];  //单月可使用次数
                    $returnArr[$k]['total_value'] = $v['total_value'];      //总次数
                    $returnArr[$k]['cash_pay_value'] = $v['cash_pay_value'];//现金价值
                    $returnArr[$k]['service'] = '部分服务';
                }
            }
            list($this->status,$this->message,$this->data) = [1,'获取成功',$returnArr];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'卡列表获取失败'];
        }
    }

    /***
     * 查看卡详情|购买指定的卡
     */
    public function getCardDetail($params)
    {
        try{
            $getCardDetail = $this->userCardCenterLogic->getCardDetail($params);
            list($this->status,$this->message,$this->data) = [1,'获取卡详情成功',$getCardDetail];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'获取卡详情失败'];
        }
    }

    /***
     * 用户购买卡
     */
    public function userBuyCard($params)
    {
        //发起支付,拉起回执,查询表,插入表,1.查询平台卡表2.插入用户购买卡订单记录表3.插入用户卡表4.插入订单流水表.支付成功,返回回执,执行插入操作
        try{
            //发起支付,拉起回执,若支付成功执行以下代码
            $cardInfo = $this->userCardCenterLogic->getCardInfo($params);
            $userId = $params['user_id'];
            $platformCardId = $cardInfo['id'];
            $cardType = $cardInfo['card_type'];
            $periodTime = $cardInfo['period'];//使用周期
            $totalValue = $cardInfo['total_value'];//用户卡余额|剩余次数
            $cashPayValue = $cardInfo['cash_pay_value'];//现金价值
            $monthlyTimes = $cardInfo['monthly_times'];//当月剩余次数

            $userCard['user_id'] = $userId; //用户id
            $userCard['status'] = 0; //消费状态
            $userCard['platform_card_id'] = $platformCardId;//平台卡id
            $userCard['balance_value'] = $totalValue;//用户卡余额|剩余次数
            $userCard['month_balance_times'] = $monthlyTimes;//当月剩余次数
            $userCard['create_time'] = time();
            $userCard['expire_time'] = $this->dateCount(date('Y-m-d H:i:s'),$periodTime,'day');//通过使用周期,获取过期时间
            if($cardType == 1){//权益卡
                $userCard['card_number'] = getQeCardNumber();
            } elseif($cardType == 2) {//次数卡
                $userCard['card_number'] = getCsCardNumber();
            } else {
                list($this->status,$this->message) = [0,'卡号生成失败'];
                return;
            }
            Db::startTrans();

            $addUserCardId = $this->userCardCenterLogic->addUserCard($userCard); //添加用户卡表数据

            if($addUserCardId){
                /**用户购买卡订单记录表数据**/
                $userBuyCard['user_id'] = $userId;
                $userBuyCard['user_card_id'] = $addUserCardId;
                $userBuyCard['platform_card_id'] = $platformCardId;
                $userBuyCard['number'] = getOrderNumber();//订单号
                $userBuyCard['jiaoyi_number'] = mt_rand(111111,999999);//第三方交易号
                $userBuyCard['card_type'] = $cardType;//卡类型
                $userBuyCard['buy_price'] = $cashPayValue;//支付金额
                $userBuyCard['buy_type'] = mt_rand(1,2);//支付方式
                $userBuyCard['buy_status'] = 0;//支付状态

                $addUserBuyCardId = $this->userCardCenterLogic->addUserBuyCard($userBuyCard); //添加用户购买卡订单

                if($addUserBuyCardId){
                    $orderDetail['order_type'] = 1;
                    $orderDetail['order_id'] = $addUserBuyCardId;//订单id

                    $addOrderDetail = $this->userCardCenterLogic->addUserBuyCardOrder($orderDetail);//新增订单流水表数据

                    if($addOrderDetail){
                        Db::commit();
                        list($this->status,$this->message,$this->data) = [1,'支付成功',$addUserBuyCardId];
                        return;
                    } else {
                        Db::rollback();
                        list($this->status,$this->message) = [0,'支付失败'];
                        return;
                    }
                } else {
                    Db::rollback();
                    list($this->status,$this->message) = [0,'支付失败'];
                    return;
                }
            } else {
                Db::rollback();
                list($this->status,$this->message) = [0,'支付失败'];
                return;
            }
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'支付失败'];
        }
    }

    /***
     * 我的订单列表
     * @param $params
     */
    public function userMyOrder($params)
    {
        try{
            $userMyOrder = $this->userCardCenterLogic->userMyOrder($params);
            list($this->status,$this->message,$this->data) = [1,'订单获取成功',$userMyOrder];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'订单获取失败'];
        }
    }
    /***
     * 查看我的订单详情
     */
    public function catMyOrderDetail($params)
    {
        try{
            $catMyOrderDetail = $this->userCardCenterLogic->catMyOrderDetail($params);
            list($this->status,$this->message,$this->data) = [1,'订单详情获取成功',$catMyOrderDetail];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,$e->getMessage()];
        }
    }

    /***
     * 卡包中心使用说明
     */
    public function instructions()
    {
        try{
            $instructions = $this->userCardCenterLogic->instructions();
            if(empty($instructions)){
                list($this->status,$this->message) = [1,'获取成功'];
                return;
            }
            list($this->status,$this->message,$this->data) = [1,'获取成功',$instructions['content']];
        }catch(\Exception $e){
            list($this->status,$this->message) = [0,'卡包使用说明获取失败'];
        }
    }

    /***
     * 获取指定日期的前/后多少天,月,年
     * @param $vdate
     * @param $vnum
     * @param $vtype
     * @return false|int
     */
    public function dateCount($vdate, $vnum, $vtype) {
        $day = date('j', strtotime($vdate));
        $month = date('n', strtotime($vdate));
        $year = date('Y', strtotime($vdate));
        switch ($vtype) {
            case 'day':
                if ($vnum >= 0) {
                    $day = $day + abs($vnum);
                } else {
                    $day = $day - abs($vnum);
                }
                break;
            case 'month':
                if ($vnum >= 0) {
                    $month = $month + abs($vnum);
                } else {
                    $month = $month - abs($vnum);
                }
                $next = $this->getDays($month, $year); //获取变换后月份的总天数
                if($next<$day){
                    $day = $next;
                }
                break;
            case 'year':
                if($vnum >= 0){
                    $year = $year+ abs($vnum);
                }else{
                    $year = $year - abs($vnum);
                }
                break;
            default :
                break;
        }
        return mktime(0,0,0,$month,$day,$year)+86400;

    }

    /***
     * 获取给定月份的天数
     * @param $month
     * @param $year
     * @return int
     */
    public function getDays($month,$year){
        switch($month){
            case '1':
            case '3':
            case '5':
            case '7':
            case '8':
            case '10':
            case '12':
                return 31;
                break;
            case '4':
            case '6':
            case '9':
            case '11':
                return 30;
                break;
            case '2':
                if(($year%4==0 && $year%100!=0) || $year%400==0){//整百的年份要同时满足400的倍数才算闰年
                    return 29;
                }else{
                    return 28;
                }
                break;
        }
    }

}