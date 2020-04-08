<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/20
 * Time: 14:36
 */

namespace app\common\model;

use think\Db;
use think\Model;

/***
 * 商家流水表模型
 * Class SellerBalance
 * @package app\common\model
 */
class SellerBalance extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /**
     * 提现详情
     * @param cash_account_id 提现id
     */
    public function spDetails($params)
    {
        $result = Db::name('seller_cash')->alias('sc')
            ->join('dp_cash_account ca','sc.cash_account_id = ca.id')
            ->join('dp_seller_balance sb','sb.cash_account_id = sc.id','left')
            ->where('sc.id',$params["cash_account_id"])
            ->field('sc.id,sc.cash_status,sc.cash_time,sc.make_time,ca.account_type,ca.account,sb.create_time')
            ->select();
        return $result ? $result : [];
    }

    /**
     * 支出记录
     * @param seller_id 商家id
     */
    public function spendRecord($params)
    {
        $result = $this
        ->where("seller_id=".$params["seller_id"]." and is_balance = 2")
        ->order('create_time desc')
        ->field('cash_account_id,price,create_time,is_balance')
        ->select();
        return $result ? $result : [];
    }

    /**
     * 收入记录
     * 商户提现被驳回的记录,提现id>0,进账
     * @param seller_id 商家id
     */
    public function incomeRecord($seller_id)
    {
        return  $this->where("seller_id =$seller_id and cash_account_id>0 and is_balance = 1")
            ->field("cash_account_id,price,create_time,is_balance")
            ->select();
    }

    /**
     * 商家出账金额
     * @param seller_id 商家id
     */
    public function out($seller_id)
    {
        return $this->where("seller_id=$seller_id and is_balance = 2")->sum('price');//进账金额
    }

    /**
     * 商家进账金额
     * @param seller_id 商家id
     */
    public function income($seller_id)
    {
        return $this->where("seller_id=$seller_id and is_balance = 1")->sum('price');//进账金额
    }

    /**
     * 商家进账
     */
    public function addIncome($income)
    {
        $this->save($income);
        return $this->id;
    }
}