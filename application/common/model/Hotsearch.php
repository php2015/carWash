<?php 
namespace app\common\model;
use think\Db;
use think\Model;

class Hotsearch extends Model{
    /**
     * 用户的 搜索历史
     * @param user_id 用户id
     */
    public function searchHistory($user_id)
    {
        $map['user_id'] = $user_id;
        $result = $this->where($map)
                ->field('keywords')
                ->distinct(true)
                ->limit(10)
                ->order('create_time desc')
                ->select();
        return $result ? $result : [];
    }

    /**
     * 热门搜索
     */
    public function searchHot()
    {
        $result = $this
            ->limit(10)
            ->field("count(id) as serch_num,keywords")
            ->group('keywords')
            ->order('serch_num desc')
            ->limit(10)
            ->select();
        return $result ? $result : [];
    }

    /**
     * 清空历史搜索记录
     * @param user_id 用户id
     */
    public function clearSearch($user_id){
        $map['user_id'] = $user_id;
        return $this->where($map)->delete();
    }

    /**
     * 添加搜索记录
     * @param user_id 用户id
     * @param keywords 搜索词
     */
    public function addSearch($params)
    {
        $data = ['user_id'=>$params['user_id'], 'keywords'=>$params['keywords'],'create_time'=>time()];
        $this->insert($data);
    }
}