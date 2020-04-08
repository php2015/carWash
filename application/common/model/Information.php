<?php
namespace app\common\model;

use think\Db;
use think\Model;
class Information extends Model
{
   /**
     *  查询有资讯文章 的 资讯分类
     */
    public function newsClass()
    {
        $map['ic.is_rease'] = 1;//资讯分类 启用状态:0不启 1启
        $map['ic.is_delete'] = 0;//资讯分类 删除状态:0不删,1删
        $map['i.is_release'] = 1;//资讯文章 是否发布 (0表示不发布,1表示发布)
        $map['i.is_delete'] = 0;//资讯文章 删除状态:0不删,1删
        $result = Db::name('information_cate')->alias('ic')
            ->join('dp_information i','ic.id = i.information_cate_id')
            ->where($map)
            ->order('ic.order_num desc')
            ->field('ic.id,ic.name')
            ->select();
        return $result ? $result : [];
    }

    /**
     *  资讯列表 || 每页行数为50
     * @param class_id 资讯分类id
     * @param page 页数
     */
    public function newsList($class_id,$page)
    {
        $limit = 50;
        $page = $page ? $page : 1;
        // 查找分类下的文章
        $map['information_cate_id'] = $class_id;
        $result = $this
            ->where($map)
            ->page($page,$limit)
            ->order('order_num desc')
            ->field('id,title,icon,source')
            ->select();
        return $result ? $result : [];
    }

    /**
     * 资讯详情
     * @param id 资讯id
     */
    public function newsDetail($params)
    {
        // 通过资讯id查找文章
        $result = $this->alias('i')
            ->join('dp_information_cate ic','i.information_cate_id = ic.id')
            ->where('i.id='.$params['id'])
            ->field('i.title,i.source,i.create_time,ic.name,i.detail')
            ->find();
        return $result ? $result : [];
    }
}