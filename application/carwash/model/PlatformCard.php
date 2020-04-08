<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/6
 * Time: 18:06
 */

namespace app\carwash\model;

use think\Db;
use think\Model;

class PlatformCard extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 在售卡种 卡状态为启用状态的所有卡
     * @param $condition
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function onSaleCard($condition)
    {
        return $this->field("id,cash_pay_value,sale_status,
        cardname,create_time,card_type,CONCAT(period,' 天') as period,monthly_times,
        IF(card_type=1,'',CONCAT(monthly_times,' 次')) as monthly_times,
        IF(card_type=1,CONCAT(total_value,' 权益值'),CONCAT('共',total_value,' 次')) as total_value")
            ->where('sale_status',1)
            ->where($condition)
            ->paginate();
    }
    /***
     * 新增卡种
     * @param $addPlatformCardData $
     * @return mixed
     */
    public function addPlatformCard($addPlatformCardData)
    {
        $this->save($addPlatformCardData);
        return $this->id;
    }

    /***
     * 查询卡信息
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function catCardInfo($id)
    {
        return $this
            ->field("id,card_type,
            IF(card_type=1,total_value,total_value) as total_rights,
            IF(card_type=2,total_value,total_value) as total_times,
            cardname,cash_pay_value,period,monthly_times,sale_status")
            ->where('id',$id)->find();
    }

    /***
     * 查看购买历史
     * @param $id
     * @param $condition
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function buyHistory($id,$condition)
    {

        return Db::name('user_buycard')
            ->field("ub.number,ub.jiaoyi_number,ub.card_type,ub.buy_price,ub.buy_type,ub.buy_status,ub.create_time,u.nickname,u.mobile,pc.cardname,pc.cash_pay_value,uc.card_number")
            ->alias('ub')
            ->join('dp_user u','ub.user_id = u.id','left')
            ->join('dp_platform_card pc','ub.platform_card_id = pc.id','left')
            ->join('dp_user_card uc','uc.id = ub.user_card_id','left')
            ->where('ub.platform_card_id',$id)
            ->where($condition)
            ->order('ub.create_time desc')
            ->paginate();
    }

    /***
     * 卡种列表测试
     * @param $condition
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function listOfCard($condition)
    {
        return Db::name('user_card')
              ->field("uc.create_time,uc.expire_time,CONCAT(pc.period,' 天') as period,
              IF(pc.card_type=1,CONCAT(pc.total_value,' 权益值'),CONCAT('共',pc.total_value,' 次')) as total_value,
              pc.cash_pay_value,pc.cardname,pc.card_type,uc.card_number,u.nickname,u.mobile,
              IF(pc.card_type=1,'',CONCAT('剩余',uc.month_balance_times,' 次')) as month_balance_times,
              IF(pc.card_type=1,CONCAT(uc.balance_value,'权益值'),CONCAT(uc.balance_value,' 次')) as balance_value,
              IF(unix_timestamp(now()) > uc.expire_time,'0','1') as is_expire
              ")
            ->alias('uc')
            ->join("dp_platform_card pc",'uc.platform_card_id = pc.id','left')
            ->join("dp_user u","uc.user_id = u.id")
            ->where($condition)
            ->order('pc.create_time desc')
            ->paginate();
    }

    /***
     * 卡种列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function cardList($condition)
    {
        $field = "uc.id,uc.create_time,uc.expire_time,CONCAT(pc.period,' 天') as period,
                pc.monthly_times,pc.cash_pay_value,pc.cardname,pc.card_type,uc.card_number,
                u.nickname,u.mobile,uc.month_balance_times,pc.total_value,uc.balance_value,
                IF(unix_timestamp(now()) > uc.expire_time,'0','1') as is_expire";

        $subQuery = Db::table('dp_user_card')
            ->field($field)
            ->alias('uc')
            ->join("dp_platform_card pc",'uc.platform_card_id = pc.id','left')
            ->join("dp_user u","uc.user_id = u.id",'left')
            ->where($condition)
            ->buildSql();
        $time = 'create_time >='.strtotime(date('Y-m-01')).' and create_time <='.strtotime(date('Y-m-t 23:59:59'));
        //$time = 'create_time >=1541001600 and create_time <=1543593599';
        $subQuerySon = Db::table('dp_user_card_statement')->where($time)->buildSql();
        $fieldSon = "count(ucs.user_card_id) as useInMonth,m.id,
                m.total_value,
                m.balance_value,
                m.monthly_times,
                ucs.user_card_id,m.create_time,m.is_expire,m.expire_time,m.cash_pay_value,m.cardname,m.card_type,m.card_number,m.nickname,
                m.mobile,m.period";
        return Db::table($subQuery . ' m')
               ->field($fieldSon)
               ->join($subQuerySon .' ucs','m.id = ucs.user_card_id','left')
               ->group('m.id')
               ->order('m.create_time desc')
               ->paginate()->each(function($item, $key){
                    if($item['card_type'] == 1){ //如果是权益值,无当月剩余次数

                        $item['balance_value'] = '剩余' . $item['balance_value'] . '权益值';
                        $item['total_value'] = '共' . $item['total_value'] . '权益值';
                        $item['monthRestTimes'] = '';

                    } elseif ($item['card_type'] == 2){

                        $item['total_value'] = '共' . $item['total_value'] . '次';

                        //单月剩余使用次数
                        $item['monthRestTimes'] = $item['monthly_times'] - $item['useInMonth'];

                        if($item['balance_value'] < $item['monthRestTimes']){
                            if($item['balance_value'] <= 0){
                                $item['monthRestTimes'] = '剩余0次';
                            } else {
                                $item['monthRestTimes'] = '剩余' . $item['balance_value'] . '次';
                            }
                        } else {
                            $item['monthRestTimes'] = '剩余' . ($item['monthly_times'] - $item['useInMonth']) .'次';
                        }
                        //卡种余额
                        $item['balance_value'] = '剩余' . $item['balance_value'] . '次';
                    }

                    return $item;
            });
    }
}