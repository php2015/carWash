<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/11
 * Time: 15:23
 */

namespace app\carwash\model;


use think\Db;
use think\Model;

class PlatformCount extends Model
{
    /***
     * 平台总用户数
     */
    public function countUserNum()
    {
        return Db::table('dp_user')->where('is_disable',0)->count('id');
    }
    /***
     * 加盟的商家总数
     */
    public function countSellerNum()
    {
        return Db::table('dp_seller')->where('is_review',1)->count('id');
    }

    /***
     * 待审核商家总数
     * @return int|string
     */
    public function countToDoSeller()
    {
        return Db::table('dp_seller')->where('is_review',0)->count('id');
    }

    /***
     * 待审核服务
     * @return int|string
     */
    public function countToDoService()
    {
        return Db::table('dp_seller_service')->where('is_release',0)->count('id');
    }
    /***
     * 商家总提现金额
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function countSellerCashNum()
    {
        return Db::table('dp_seller_balance')->field("sum(price) as cashprice")->where('is_balance',2)->select();
    }

    /***
     * 平台总消费金额
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function countSellerConsumeNum()
    {
        return Db::table('dp_seller_balance')->field("sum(price) as consumeprice")->where('is_balance',1)->select();
    }

    /***
     * 平台已打款总提现手续费
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function countCashFee()
    {
        return Db::table('dp_seller_cash')->field("sum(cash_fee) as sumcashfee")->where('cash_status',3)->select();
    }

    /***
     * 待处理提现请求个数
     * @return int|string
     */
    public function countCashToDoFee()
    {
        return Db::table('dp_seller_cash')->where('cash_status',1)->count('id');
    }
}