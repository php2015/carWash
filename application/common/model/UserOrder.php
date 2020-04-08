<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/14
 * Time: 18:04
 */

namespace app\common\model;

use think\Db;
use think\Model;

/****
 * 商家订单模型
 * Class UserOrder
 * @package app\common\model
 * @author ywdeng
 * @property integer id 订单id
 * @property integer user_id 用户id
 * @property integer seller_id 商家id
 * @property integer seller_service_id 服务id
 * @property string  seller_staff_id 商家员工id
 * @property string  goods_name 商品名称
 * @property string  goods_price 商品价格
 * @property string  payprice 支付金额
 * @property string  card_number 卡号
 * @property integer create_time 创建时间
 * @property integer settlement_type 结算方式 [1.权益卡 2.次数卡]
 * @property integer pay_status 支付状态 [0.支付失败 1.支付成功 2.未支付]
 * @property integer is_valid 订单是否有效 [0.无效 1.有效]
 * @property integer is_comment 是否评价 [0.未评价 1.已评价]
 */
class UserOrder extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /**
     * 用户在该商店支付成功的记录
     * chenxin
     * @param seller_id 商家id
     */
    public function userSucHistory($seller_id)
    {
        return  $this->alias('uo')
                ->join('dp_user u','uo.user_id=u.id','left')
                ->join('dp_seller_service ss','ss.id=uo.seller_service_id')
                ->where("uo.seller_id=$seller_id and uo.pay_status = 1")
                ->field('u.nickname,ss.servicename,uo.payprice as price,uo.create_time')
                ->order('uo.create_time desc')
                ->select();
    }

    /***
     * 查看服务购买记录
     * @param $params
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getServiceOrder($params)
    {
        $where['pay_status'] = 1;
        $where['is_valid'] = 0;//有效
        $where['seller_id'] = $params['seller_id'];//商家id
        $where['seller_service_id'] = $params['seller_service_id'];//商家服务id
        $field = 'id,user_id,seller_id,seller_service_id,seller_staff_id,goodsname,goodsprice,payprice,order_number,create_time,settlement_type,pay_status,is_valid,is_comment';
        $joinField = 'uo.*,u.nickname,u.mobile,IF(seller_staff_id=0,s.shopkeeper,ss.staffname) as staffname';
        $subQuery = $this->field($field)->where($where)->buildSql();
        return Db::table($subQuery .' uo')
            ->field($joinField)
            ->join('dp_seller_staff ss','uo.seller_staff_id = ss.id','left')
            ->join('dp_seller s','uo.seller_id = s.id','left')
            ->join('dp_user u','uo.user_id = u.id','left')
            ->select();
    }

    /***
     * 获取当前商家的所有订单
     * @param $sellerId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getServiceAllOrder($sellerId,$where,$order)
    {
        $where['pay_status'] = 1;//支付成功
        $where['is_valid'] = 0;//有效
        $where['seller_id'] = $sellerId;//商家id
        $order .= 'uo.create_time desc';
        $field = 'id,user_id,seller_id,seller_service_id,seller_staff_id,goodsname,goodsprice,payprice,order_number,create_time,settlement_type,pay_status,is_valid,is_comment';
        $joinField = 'uo.*,u.nickname,u.mobile,IF(seller_staff_id=0,s.shopkeeper,ss.staffname) as staffname';
        $subQuery = $this->field($field)->where($where)->buildSql();
        return Db::table($subQuery .' uo')
            ->field($joinField)
            ->join('dp_seller_staff ss','uo.seller_staff_id = ss.id','left')
            ->join('dp_seller s','uo.seller_id = s.id','left')
            ->join('dp_user u','uo.user_id = u.id','left')
            ->order($order)
            ->select();
    }

    /***
     * 查看订单详情
     * @param $sellerId
     * @param $orderId
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catOrderDetail($orderId)
    {
        $where['id'] = $orderId;
        $where['pay_status'] = 1;
        $where['is_valid'] = 0;
        $order = 'uo.create_time asc';
        $field = 'id,user_id,seller_id,seller_service_id,seller_staff_id,goodsname,goodsprice,payprice,order_number,create_time,settlement_type,pay_status,is_valid,is_comment';
        $joinField = 'uo.*,u.nickname,u.mobile,IF(seller_staff_id=0,s.shopkeeper,ss.staffname) as staffname';
        $subQuery = $this->field($field)->where($where)->buildSql();
        return Db::table($subQuery .' uo')
            ->field($joinField)
            ->join('dp_seller_staff ss','uo.seller_staff_id = ss.id','left')
            ->join('dp_seller s','uo.seller_id = s.id','left')
            ->join('dp_user u','uo.user_id = u.id','left')
            ->order($order)
            ->select();
    }

    /***
     * 设置订单消息全部为已读
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function allOrderRead(){
        $map["type"] = 3;//订单类型
        return Db::name('seller_message')->where($map)->update(['is_read' => 1]);
    }

    
    /***
     * 新增订单
     * @param $order
     * @return int
     */
    public function addOrder($order)
    {
        $this->save($order);
        return $this->id;
    }

    /**
     * 用户消费记录 列表
     * @author 陈鑫
     * @param user_id 用户id
     * @param page 页数
     */
    public function expendList($params){
        $map['uo.user_id'] = $params['user_id'];
        $map['s.is_disabled'] = 0;//商家未下架
        $map['s.is_review'] = 1;//商家是否加盟(0待处理,1已加盟)
        $map['ss.is_delete'] = 0;//服务是否删除(0不删除,1删除)
        $map['ss.is_release'] = 1;//服务状态(0禁用,1启用,2驳回)
        $map['uo.is_valid'] = 0;//订单是否有效(0有效,1无效)
        $map['uo.pay_status'] = 1;//支付状态(0支付失败,1支付成功,2未支付)
        //订单id,商家介绍图,商家名称,商家服务名称,付款时间,付款金额,是否评价
        $field = 'uo.id as order_id,s.seller_pic3,s.sellername,ss.servicename,uo.create_time,uo.payprice,uo.is_comment,s.id as seller_id,s.address';
        $result = $this->alias('uo')
            ->join('dp_seller s','uo.seller_id = s.id')
            ->join('dp_seller_service ss','uo.seller_service_id = ss.id')
            ->where($map)
            ->field($field)
            ->page($params['page'],30)
            ->order('uo.create_time desc')
            ->select();
        return $result ? $result : [];
    }

    
}