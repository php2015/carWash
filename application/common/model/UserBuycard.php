<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/28
 * Time: 15:30
 */

namespace app\common\model;

use think\Db;
use think\Model;

/***
 * 用户购买卡订单记录模型
 * Class UserBuycard
 * @package app\common\model
 * @property integer id               用户购买卡记录id
 * @property integer user_id          用户id
 * @property integer platform_card_id 平台卡id
 * @property integer user_card_id     用户卡id
 * @property string  number           订单号
 * @property string  jiaoyi_number    第三方交易号
 * @property integer card_type        卡类型[1权益卡|2次数卡]
 * @property integer buy_price        支付金额
 * @property integer buy_type         支付类型[1支付宝|2微信]
 * @property integer buy_status       购买状态[0成功|1失败]
 * @property integer create_time      购买时间
 */
class UserBuycard extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 新增用户购买卡订单记录
     * @param $params
     * @return mixed
     */
    public function addUserBuyCard($params)
    {
        $this->save($params);
        return $this->id;
    }

    /****
     * 查看我的订单列表
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function userMyOrder($params)
    {
        $where['user_id'] = $params['user_id'];
        $paginate = $params['paginate'];
        $field = 'ub.id,pc.cardname,ub.buy_price,ub.create_time,buy_status';
        return $this
            ->field($field)
            ->alias('ub')
            ->join('dp_platform_card pc','pc.id = ub.platform_card_id','left')
            ->where($where)
            ->page($paginate,30)
            ->order('ub.create_time desc')
            ->select();
    }

    /***
     * 查看我的订单详情
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catMyOrderDetail($params)
    {
        $where['ub.id'] = $params['user_buycard_id'];
        $field = "pc.cardname,ub.buy_status,ub.buy_price,uc.card_number,uc.balance_value,pc.cash_pay_value,
        pc.monthly_times,uc.create_time,uc.expire_time,IF(ub.card_type=1,'全部服务','部分服务') as service,
        ub.card_type,ub.number,ub.buy_type";
        return $this->field($field)
            ->alias('ub')
            ->join('dp_user_card uc','uc.id = ub.user_card_id','left')
            ->join('dp_platform_card pc','ub.platform_card_id = pc.id')
            ->where($where)
            ->find();
    }

    /**
     *  获取用户 可用卡张数
     * @param user_id
     * @param type qy=>权益卡 cs=>次数卡
     */
    public function getQyCard($user_id,$type)
    {
        $map['ub.user_id'] = $user_id;
        if($type == 'qy'){
            $map['ub.card_type'] = 1;//卡 类型 权益
        }else{
            $map['ub.card_type'] = 2;//卡 类型 次数
        }
        $map['uc.status'] = 0;//卡 为正常消费状态
        $result = $this->alias('ub')
            ->join('dp_user_card uc','ub.user_card_id = uc.id')
            ->where($map)
            ->count();
        return $result ? $result : 0;
    }
}