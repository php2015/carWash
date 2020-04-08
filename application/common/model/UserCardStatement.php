<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/20
 * Time: 10:12
 */

namespace app\common\model;

use think\Db;
use think\Model;

/***
 * 用户卡消费记录模型
 * Class userCardStatement
 * @package app\common\model
 * @property integer id          用户卡消费记录表id
 * @property integer  card_type  卡类型[1权益卡|2次数卡]
 * @property integer  user_id    用户id
 * @property integer create_time 消费时间
 */
class UserCardStatement extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 获取用户当前次卡当月消费次数
     * @param $params
     * @return int|string
     */
    public function monthUseCiShu($params)
    {

        $time = 'create_time >='.strtotime(date('Y-m-01')).' and create_time <='.strtotime(date('Y-m-t 23:59:59'));
        $where['card_type'] = 2;
        $where['user_card_id'] = $params['user_card_id'];
        $where['user_id'] = $params['user_id'];
        return $this->where($where)->where($time)->count('id');
    }

    /***
     * 获取用户当前次卡总消费次数
     * @param $params
     * @return int|string
     */
    public function totalUseCiShu($params)
    {
        $where['card_type'] = 2;
        $where['user_card_id'] = $params['user_card_id'];
        $where['user_id'] = $params['user_id'];
        return $this->where($where)->count('id');
    }

    /***
     * 新增用户次卡消费记录
     * @param $userKaXfDetailArr
     * @return false|int
     */
    public function addCsCardXf($userKaXfDetailArr)
    {
        return $this->save($userKaXfDetailArr);
    }

    /***
     * 新增权益卡消费记录
     * @param $userKaXfDetailArr
     * @return array|false
     * @throws \Exception
     */
    public function addQeCardXf($userKaXfDetailArr)
    {
        return $this->saveAll($userKaXfDetailArr);
    }
}