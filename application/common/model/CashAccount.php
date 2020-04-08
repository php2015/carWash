<?php
/**
 * Created by Vs.
 * User: chenxin
 * Date: 2018/9/30
 * Time: 14:36
 */

namespace app\common\model;

use think\Db;
use think\Model;

/***
 * 商家提现账号表
 * Class CashAccount
 * @package app\common\model
 */
class CashAccount extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /**
     * 提现
     * @param seller_id 商家id
     * @param cash_account_id 提现账号表id
     * @param cash_price 提现金额
     * @param nowbalance 当前余额(logic层算出的,不是传参数据)
     */
    public function withdrawCash($params){
        $times = time();
        try{
             // 1.写入进 商家提现表(dp_seller_cash)
            $data = [
                'seller_id' => $params["seller_id"], 'cash_account_id' => $params["cash_account_id"],
                'nowbalance' => $params["nowbalance"],  'cash_price' => $params["cash_price"],
                'cash_status'   => 1
            ];
            Db::name('seller_cash')->insert($data);
            $cash_account_id = Db::name('seller_cash')->getLastInsID();
            // 2.把操作1返回的提现id加入到参数里,再写入商家流水/商家收支记录表(dp_seller_balance)
            $result = [
                'seller_id' => $params["seller_id"], 'price' => $params["cash_price"],
                'is_balance'  => 2, 'cash_account_id' => $cash_account_id,
                'create_time' => $times
            ];
            Db::name('seller_balance')->insert($result);
            // 3.提现操作写入到商家消息中心表
            $account_name = $this->where("id",$params["cash_account_id"])->field('account_name')->find();
            $msg = [
                'title' => '发起提现','content' => '尊敬的'.$account_name["account_name"].',您于'.date("Y-m-d H:i:s",$times).'发起提现号为'.$cash_account_id.'的提现已发起,请知晓',
                'create_time' => $times,'seller_id' => $params["seller_id"],'type' => 10
            ];
            Db::name('seller_message')->insert($msg);
            return 1;
        }catch(\Exception $e){
            return 0;
        }
    }

    /**
     * 返回商家 可用的提现账号信息
     * @param seller_id 商家id
     */
    public function accountInfo($params){
        $result = $this->where("status = 1 and is_delete != 1")
        ->field('id,account_type,account')
        ->select();
        return $result ? $result : [];
    }

    /**
     * 获取 账号 编辑信息
     * @param id 账号id
     */
    public function editAccountInfo($params){
        $result = $this->where("id = ".$params["id"])
        ->field('account,mobile,account_name,idcard,bank_card_id')
        ->find();
        return $result ? $result : [];
    }

    /**
     * 可用银联卡信息 => 返回可用开户行id和名称
     */
    public function bankInfo(){
        $result = Db::name('bank_card')->where("status = 1 and is_delete != 1")->field('id,name')->select();
        return $result ? $result : [];
    }

    /**
     * 编辑银行卡账户
     * @param seller_id 商家id
     * @param type 账户类型 1.支付宝 2.微信 3.银行卡
     * @param account 账号
     * @param mobile 手机号
     * @param account_name 持卡人姓名
     * @param bank_id 开户行(后台银行卡表id)
     * @param idcard 身份证号
     */
    public function editBankAcount($params)
    {
        $data = [
            'account' => $params["account"], 'mobile' => $params["mobile"],
            'account_name' => $params["account_name"], 'idcard' => $params["idcard"],
            'bank_card_id' => $params["bank_id"]
        ];
        return $this->where("seller_id =".$params["seller_id"]." and account_type=".$params["type"])->update($data);
    }

    /**
     * 编辑 支付宝/微信 账户
     * @param seller_id 商家id
     * @param type 账户类型 1.支付宝 2.微信 3.银行卡
     * @param account 账号
     * @param mobile 手机号
     * @param account_name 持卡人姓名
     */
    public function editAccount($params)
    {
        $data = ['account_name' => $params["account_name"], 'account' => $params["account"], 'mobile' => $params["mobile"]];
        return $this->where("seller_id =".$params["seller_id"]." and account_type=".$params["type"])->update($data);
    }

    /**
     * 新增银行卡账户 | 后台控制是否启用
     * @param seller_id 商家id
     * @param type 账户类型 1.支付宝 2.微信 3.银行卡
     * @param account 账号
     * @param mobile 手机号
     * @param account_name 持卡人姓名
     * @param bank_id 开户行(后台银行卡表id)
     * @param idcard 身份证号
     */
    public function addBankAcount($params)
    {
        $data = [
            'seller_id' => $params["seller_id"], 'account_type' => $params["type"],
            'account' => $params["account"], 'mobile' => $params["mobile"],
            'account_name' => $params["account_name"], 'idcard' => $params["idcard"], 'status' => 1,
            'bank_card_id' => $params["bank_id"], 'create_time' => time()
        ];
        return $this->insert($data);
    }

    /**
     * 新增 支付宝/微信 账户 | 后台控制是否启用
     * @param seller_id 商家id
     * @param type 账户类型 1.支付宝 2.微信 3.银行卡
     * @param account 账号
     * @param mobile 手机号
     * @param account_name 持卡人姓名
     */
    public function addAcount($params)
    {
        $data = [
            'seller_id' => $params["seller_id"], 'account_type' => $params["type"],
            'account' => $params["account"], 'mobile' => $params["mobile"], 'status' => 1,
            'account_name' => $params["account_name"], 'create_time' => time()
        ];
        return $this->insert($data);
    }

    /**
     * 提现账户列表 => 查看银行卡账号
     * @param seller_id 商家id
     * @param type 查看类型 3 = 银行卡
     */
    public function bankAcount($params)
    {   
        $result = $this->alias('ca')
                ->join('dp_bank_card bc','ca.bank_card_id = bc.id','left')
                ->where("ca.seller_id=".$params["seller_id"]." and ca.account_type = 3 and bc.status =1 and bc.is_delete != 1 and ca.is_delete !=1")
                ->field('bc.name,bc.img,ca.account_name,ca.account,ca.id,ca.idcard,ca.mobile,bc.id as bank_card_id,bc.icon')
                ->find();
        return $result ? $result : "";
    }

    /**
     * 提现账户列表 => 查看微信账号
     * @param seller_id 商家id
     * @param type 查看类型 2 = wechat
     */
    public function wechatAcount($params)
    {   
        $result = $this
                ->where("seller_id=".$params["seller_id"]." and account_type = 2  and is_delete != 1")
                ->field('id,account,mobile,account_name')
                ->find();
        return $result ? $result : "";
    }

    /**
     * 提现账户列表 => 查看支付宝账户
     * @param seller_id 商家id
     * @param type 查看类型 1 = 支付宝
     */
    public function aliAcount($params)
    {   
        $result = $this->where("seller_id=".$params["seller_id"]." and account_type = 1 and is_delete != 1")
                ->field('id,account,mobile,account_name')
                ->find();
        return $result ? $result : "";
    }

    /**
     * 判断账户添加情况
     * @param seller_id 商家id
     */
    public function accountStatus($seller_id = '')
    {
        $result = $this->where("seller_id=".$seller_id." and is_delete = 0")
                ->field('account_type')
                ->select();
        return $result ? $result : "";
    }

    /**
     * 判断提现账号是否可用
     */
    public function accountUse($cash_account_id = 0)
    {
        $result = $this->where('id ='.$cash_account_id.' and is_delete != 1 and status = 1')->find();
        return $result ? $result : "";
    }

    /**
     * 账号可用提现选择列表 
     * @param seller_id 商家id
     */
    public function AccountAvailable($params)
    {
        $result = $this->where('seller_id ='.$params['seller_id'].' and is_delete != 1 and status = 1')->field('id,account_type,account')->order('account_type')->select();
        return $result ? $result : [];
    }

}