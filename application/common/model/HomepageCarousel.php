<?php
namespace app\common\model;
use think\Db;
use think\Model;

class HomepageCarousel extends Model{
    /**
     * 首页轮播图
     */
    public function carousel()
    {
        $map['location'] = 2;//用户端
        $map['is_delete'] = 0;//未删除
        $map['is_release'] = 1;//启用
        $field = 'picture,adname,order_num,linkurl,type,info_id';
        $result = $this
                ->where($map)
                ->where(function($query){
                    $query->where('expire_time',['>',time()],['=',0],'or');
                })
                ->field($field)
                ->select();
        return $result ? $result : [];
    }
}