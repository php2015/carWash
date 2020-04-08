<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/20
 * Time: 15:59
 */

namespace app\common\model;


use think\Model;

/***
 * 用户消费记录明细模型
 * Class UserConsumerdetails
 * @package app\common\model
 */
class UserConsumerdetails extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 新增用户消费记录
     * @param $userXfDetail
     * @return false|int
     */
    public function addUserXfDetail($userXfDetail)
    {
        return $this->save($userXfDetail);
    }
}