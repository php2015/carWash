<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/26
 * Time: 19:18
 */

namespace app\common\model;


use think\Model;

/***
 * 收藏模型
 * Class Collect
 * @package app\common\model
 * @property integer  id          收藏id
 * @property integer  user_id     用户id
 * @property integer  seller_id   商家id
 * @property string   create_time 收藏时间
 * @property integer  is_remove   是否移除[0不移除|1移除]
 */
class Collect extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳

    /***
     * 查看用户是否收藏商家
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isCollectionBiz($params)
    {
        $where['user_id'] = $params['user_id'];
        $where['seller_id'] = $params['seller_id'];
        $where['is_remove'] = 0;
        return $this->where($where)->find();
    }

    /***
     * 查询是否已在收藏列表中,但是被移除
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function isCollect($params)
    {
        $where['user_id'] = $params['user_id'];
        $where['seller_id'] = $params['seller_id'];
        return $this->where($where)->find();
    }

    /***
     * 更新收藏状态
     * @param $params
     * @return Collect
     */
    public function updateCollect($params)
    {
        $where['id'] = $params['collect_id'];
        $is_remove = $params['is_remove'];
        return $this->where($where)->update(['is_remove'=>$is_remove]);
    }

    /***
     * 新增收藏
     * @param $params
     * @return false|int
     */
    public function addCollect($params)
    {
        $data['user_id'] = $params['user_id'];
        $data['seller_id'] = $params['seller_id'];
        $data['is_remove'] = 0;
        $this->save($data);
        return $this->id;
    }

    /**
     * 我的收藏列表
     * @param user_id 用户id
     * @param page 页数
     * @param lat 纬度
     * @param lon 经度
     */
    public function myCollectList($user_id,$page,$lat = 0,$lon = 0)
    {
        $page = $page ? $page : 1;
        $map['c.user_id'] = $user_id;
        // $map['c.is_remove'] = 0;       //是否移除(0不移除,1移除)
        $field = "s.id,s.sellername,s.lon,s.lat,s.address,s.seller_pic3,c.user_id,s.is_disabled as is_remove,
        ROUND(6378.138 * 2 * ASIN(SQRT(POW( SIN( ({$lat} * PI() / 180 - lat * PI() / 180 ) / 2),2) + COS({$lat} * PI() / 180) * COS(lat * PI() / 180) * POW(SIN( ({$lon} * PI() / 180 - lon * PI() / 180) / 2),2))) * 1000) AS `range`";
        $result = $this->alias('c')
                    ->join('dp_seller s','c.seller_id = s.id')
                    ->where($map)
                    ->field($field)
                    ->page($page,30)
                    ->order('c.is_remove,c.create_time desc')
                    ->select();
        return $result ? $result : [];
    }

    /**
     * 取消收藏
     * @param user_id 用户id
     * @param seller_id 商家id
     */
    public function removeCollect($user_id,$seller_id)
    {
        return $this->where("user_id=$user_id and seller_id IN (".$seller_id.")")->delete();
    }
}