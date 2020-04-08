<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/4
 * Time: 15:46
 */

namespace app\carwash\model;


use think\Db;
use think\Model;

class UserOrder extends Model
{
    /***
     * 查询订单记录
     * @param [搜索条件] $orderRecordSearch
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function orderRecord($orderRecordSearch)
    {
        /***
         * 用户名,手机号码,
         * 服务名称,所属类别,服务价格,
         * 支付方式,支付金额,购买时间,交易单号,订单处理人,支付状态
         * 用户表,商家服务表,首页服务分类表,订单表,商家员工表
         */
        return  Db::name('user_order')->field("a.id,a.user_id,a.seller_id,a.seller_service_id,
        a.seller_staff_id,a.payprice,a.create_time,IF(a.pay_status = 2,'',a.order_number) as order_number,a.settlement_type,a.pay_status,
        b.nickname,b.mobile,c.servicename,c.serviceprice,c.homepage_cate_id,d.staffname,e.catename")
            ->alias('a')
            ->join('dp_user b','a.user_id = b.id')
            ->join('dp_seller_service c','a.seller_service_id = c.id')
            ->join('dp_seller_staff d','a.seller_staff_id = d.id')
            ->join('dp_homepage_cate e','c.homepage_cate_id = e.id')
            ->where($orderRecordSearch)
            ->order('a.id  asc')
            ->paginate();
    }

    /***
     * 导出商户订单
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exportOrderData()
    {
        return  Db::name('user_order')->field("a.id,b.nickname,b.mobile,c.servicename,e.catename,c.serviceprice,CASE WHEN a.settlement_type = 1 THEN '权益卡' WHEN a.settlement_type = 2 THEN '次数卡' ELSE '未知' END AS settlement_type,a.payprice,FROM_UNIXTIME(a.create_time) as create_time,IF(a.pay_status = 2,'',a.order_number) as order_number,d.staffname,CASE WHEN a.pay_status = 0 THEN '支付失败' WHEN a.pay_status = 1 THEN '支付成功' WHEN a.pay_status = 2 THEN '未支付' ELSE '未知' END AS pay_status")
            ->alias('a')
            ->join('dp_user b','a.user_id = b.id')
            ->join('dp_seller_service c','a.seller_service_id = c.id')
            ->join('dp_seller_staff d','a.seller_staff_id = d.id')
            ->join('dp_homepage_cate e','c.homepage_cate_id = e.id')
            ->order('a.id  asc')
            ->select();
    }

    /***
     * 平台订单记录
     * @param $condition
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function platformList($condition)
    {
        return Db::name('user_buycard')
            ->field("ub.number,ub.jiaoyi_number,ub.card_type,ub.buy_price,ub.buy_type,ub.buy_status,ub.create_time,u.nickname,u.mobile,pc.cardname,uc.card_number,pc.cash_pay_value,'平台' as platform")
            ->alias('ub')
            ->join('dp_user u','ub.user_id = u.id','left')
            ->join('dp_platform_card pc','ub.platform_card_id = pc.id')
            ->join('dp_user_card uc','ub.user_card_id = uc.id')
            ->where($condition)
            ->order('ub.create_time desc')
            ->paginate();
    }

    /***
     * 导出平台订单
     * ['ID','用户名','手机号码','所属商家','商品名称','卡种类别','卡种价格','支付金额','支付类型','第三方交易号','交易单号','卡号','支付时间','支付状态']
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exportPlatformList()
    {
        return Db::name('user_buycard')
            ->field("ub.id,u.nickname,u.mobile,'平台' as platform,pc.cardname,
            CASE WHEN ub.card_type = 1 THEN '权益卡' WHEN ub.card_type = 2 THEN '次数卡' ELSE '未知' END AS card_type,
            pc.cash_pay_value,ub.buy_price,
            CASE WHEN ub.buy_type = 1 THEN '支付宝' WHEN ub.buy_type = 2 THEN '微信' ELSE '未知' END AS buy_type,
            ub.jiaoyi_number,ub.number,uc.card_number,FROM_UNIXTIME(ub.create_time) as create_time,
            CASE WHEN ub.buy_status = 0 THEN '成功' WHEN ub.buy_status = 1 THEN '失败' ELSE '未知' END AS buy_status")
            ->alias('ub')
            ->join('dp_user u','ub.user_id = u.id','left')
            ->join('dp_platform_card pc','ub.platform_card_id = pc.id')
            ->join('dp_user_card uc','ub.user_card_id = uc.id')
            ->order('ub.create_time desc')
            ->select();
    }
}