<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/20
 * Time: 15:45
 */

namespace app\common\model;


use think\Model;

/***
 * 订单流水表
 * Class OrderDetail
 * @package app\common\model
 */
class OrderDetail extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 记录订单流水
     * @param $orderFlow
     * @return mixed
     */
    public function addOrderFlow($orderFlow)
    {
        $this->save($orderFlow);
        return $this->id;
    }

    /***
     * 记录用户买卡订单流水
     * @param $params
     * @return false|int
     */
    public function addUserBuyCardOrder($params)
    {
        return $this->save($params);
    }
}