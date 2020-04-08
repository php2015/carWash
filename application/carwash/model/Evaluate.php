<?php
namespace app\carwash\model;

use think\Model;
use think\Db;

class Evaluate extends Model
{
    /**
     * @var bool 自动写入时间戳
     */
    protected $autoWriteTimestamp = true;

    /**
     * 评价列表
     * @param $map 搜索条件
     * 用户名/商家名
    */
    public function evaList($map){
        // 用户表,商家表,评价表
        return Db::table('dp_comment')
                ->alias('c')
                ->join('dp_user u','c.user_id = u.id','left')
                ->join('dp_seller s','c.seller_id = s.id','left')
                ->join('dp_seller_service ss','c.seller_service_id = ss.id','left')
                ->field('c.*,u.nickname,s.sellername,ss.servicename')
                ->where($map)
                ->paginate();
    }
}
