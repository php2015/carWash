<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 20:14
 */

namespace app\common\model;

use think\Model;
use think\Db;

class HomepageArea extends Model
{
    protected $autoWriteTimestamp = true;

    /***
     * 获取省份城市id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getProvince()
    {
        $where['parent_id'] = 0;
        $where['is_delete'] = 0;
        $where['is_release'] = 1;
        return $this->field('id,areaname,pinyin,area_code,parent_id as type')->where($where)->select();
    }

    /**
     * 写入用户定位历史
     * @param user_id 用户id
     * @param latitude 地名
     * @param area_code 区域id
     */
    public function addUserLocal($params)
    {
        $params['create_time'] = time();
        $params['pinyin'] = getFirstCharter($params['latitude']);//获取首字母拼音大写
        $result = Db::name('position_history')->insert($params);
        return $result ? 1 : 0;
    }

    /**
     * 获取用户定位历史
     * @param user_id 用户id
     */
    public function areaHistory($uid)
    {
        $map['user_id'] = $uid;
        $result = Db::name('position_history')->where($map)->field('latitude as areaname,pinyin,area_code')->group('area_code')->limit(5)->order('create_time desc')->select();
        return $result ? $result : [['areaname'=>'重庆','pinyin'=>'C','area_code'=>'500000']];
    }

    /**
     * 获取一级城市下的区县
     * @param area_code 地区区号 截取了前三位
     */
    public function switchArea($area_code)
    {
        $map['area_code'] = ['like',"%$area_code%"];
        $result = $this->where($map)->field('id,area_code,pinyin,areaname,parent_id as type')->select();
        return $result ? $result : [];
    }
    
    /**
     * 搜索城市
     * @param areaname 城市名称
     */
    public function searchCity($areaname)
    {
        $map['areaname'] = ['like',"%$areaname%"];
        $result = $this->where($map)->field('id,area_code,pinyin,areaname,parent_id as type')->select();
        return $result ? $result : [];
    }


}