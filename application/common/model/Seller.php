<?php
/**
 * Created by PhpStorm.
 * User: ywdeng <code301@163.com>
 * Date: 2018/9/17
 * Time: 10:32
 */

namespace app\common\model;

use think\Db;
use think\Model;
/***
 * 商家表模型
 * Class Seller
 * @package app\common\model
 * @property integer id 商家id
 * @property string  sellername 商户名称
 * @property string  shopkeeper 店主姓名
 * @property integer provinces_id 省份城市id
 * @property string  address 详细地址
 * @property string  lonlat 经纬度
 * @property string  lat    经度
 * @property string  lon    纬度
 * @property string  lat_floor   精确的经度值
 * @property string  lon_floor   精确的纬度值
 * @property integer homepage_cate_parent_id 营业项目一级id
 * @property string  contactphone 店铺联系电话
 * @property string  vmphone 业务经理联系电话
 * @property string  remark  备注信息
 * @property integer order_num 排序
 * @property integer create_time 申请时间
 * @property integer update_time 加盟时间
 * @property integer start_time 开始营业时间
 * @property integer end_time 结束营业时间
 * @property integer is_review 是否加盟[0待处理|1已加盟]
 * @property integer is_disabled 是否下架[0不下架|1下架]
 * @property integer is_recommend 是否首页推荐[0不推荐|1推荐]
 * @property integer fee 提现比例
 * @property string  seller_pic1 营业执照
 * @property string  seller_pic2 店铺图片
 * @property string  seller_pic3 店铺介绍图
 */
class Seller extends Model
{
    protected $autoWriteTimestamp  = true; // 自动写入时间戳
    /**
     * 弧度
     */
    const RADIAN = 0.0253;
    /***
     * 商家入驻申请
     * @param $params
     * @return false|int
     */
    public function SellerEnterApply($params)
    {
        $this->save($params);
        return $this->id;
    }

    /***
     * 获取店铺名称|联系电话|营业时间|服务类别
     * @param $sellerId
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStoreInfo($sellerId)
    {
        $where['s.id'] = $sellerId;
        $subQuery = Db::name('homepage_cate')->alias('hc')->field('GROUP_CONCAT(hc.catename)')->where('FIND_IN_SET(hc.id,s.homepage_cate_parent_id)')->buildSql();
        return $this
            ->field("s.sellername as sellername,
            s.contactphone as contactphone,
            s.address as address,
            s.start_time as start_time,
            s.end_time as end_time,
            s.seller_pic2 as seller_pic2,
            s.seller_pic3 as seller_pic3,
            s.homepage_cate_parent_id as homepage_cate_parent_id,{$subQuery} as catename")
            ->alias('s')
            ->where($where)
            ->find()
            ->toArray();
    }

    /***
     * 更新店铺信息
     * @param $sellerId
     * @param $params
     * @return Seller
     */
    public function updateStoreInfo($sellerId,$params)
    {
        $where['id'] = $sellerId;
        return $this->where($where)->update($params);
    }

    /***
     * 商家列表
     * @param $latitude  [纬度]
     * @param $longitude [经度]
     * @param $order     [排序]
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getAllBiz($latitude, $longitude,$paginate,$order,$search)
    {
        $rad = rad2deg(self::RADIAN);
        $positions = $this->getPositions($latitude, $longitude);
        $where['is_review'] = 1;  //是否加盟,0待处理,1已加盟
        $where['is_disabled'] = 0;//是否下架,0不下架,1下架
        $where['sellername'] = ['like',"%{$search}%"];
        $whereSon['comment_type'] = 3;//好评
        $whereSon['is_release'] = 0;//是否显示,0显示|1屏蔽
        $subQuerySon = Db::table('dp_comment')->where($whereSon)->buildSql();//构建子查询
        return $this->field("s.id,s.sellername,s.address,s.seller_pic3,s.homepage_cate_parent_id,count(c.id) as totalComment,ROUND(6378.138 * 2 * ASIN(SQRT(POW( SIN( ({$latitude} * PI() / 180 - lat * PI() / 180 ) / 2),2) + COS({$latitude} * PI() / 180) * COS(lat * PI() / 180) * POW(SIN( ({$longitude} * PI() / 180 - lon * PI() / 180) / 2),2))) * 1000) AS `range`")
            ->where($where)
            //->where('lat_floor', 'in', $positions['latitudes'])
            //->where('lon_floor', 'in', $positions['longitudes'])
            //->where("lat BETWEEN {$latitude} - {$rad} and {$latitude} + {$rad}")
            //->where("lon BETWEEN {$longitude} - {$rad} and {$longitude} + {$rad}")
            ->alias('s')
            ->join($subQuerySon . ' c','s.id=c.seller_id','left')
            ->order("{$order}")
            //->having('`range` < 100000')
            ->group('s.id')
            ->page($paginate,10)
            ->select();
    }

    /***
     * 获取指定分类下的所有的商家
     * @param $latitude  [纬度]
     * @param $longitude [经度]
     * @param $order     [排序]
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getAllCateBiz($latitude, $longitude,$paginate,$order,$cateId)
    {
        $rad = rad2deg(self::RADIAN);
        $positions = $this->getPositions($latitude, $longitude);
        $where['is_review'] = 1;  //是否加盟,0待处理,1已加盟
        $where['is_disabled'] = 0;//是否下架,0不下架,1下架
        $where['homepage_cate_parent_id'] = ['like',"%{$cateId}%"];
        $whereSon['comment_type'] = 3;//好评
        $whereSon['is_release'] = 0;//是否显示,0显示|1屏蔽
        $subQuerySon = Db::table('dp_comment')->where($whereSon)->buildSql();//构建子查询
        return $this->field("s.id,s.sellername,s.address,s.seller_pic3,s.homepage_cate_parent_id,count(c.id) as totalComment,ROUND(6378.138 * 2 * ASIN(SQRT(POW( SIN( ({$latitude} * PI() / 180 - lat * PI() / 180 ) / 2),2) + COS({$latitude} * PI() / 180) * COS(lat * PI() / 180) * POW(SIN( ({$longitude} * PI() / 180 - lon * PI() / 180) / 2),2))) * 1000) AS `range`")
            ->where($where)
            //->where('lat_floor', 'in', $positions['latitudes'])
            //->where('lon_floor', 'in', $positions['longitudes'])
            //->where("lat BETWEEN {$latitude} - {$rad} and {$latitude} + {$rad}")
            //->where("lon BETWEEN {$longitude} - {$rad} and {$longitude} + {$rad}")
            ->alias('s')
            ->join($subQuerySon . ' c','s.id=c.seller_id','left')
            ->order("{$order}")
            //->having('`range` < 100000')
            ->group('s.id')
            ->page($paginate,10)
            ->select();
    }

    /***
     * 获取定位
     * @param $latitude
     * @param $longitude
     * @return mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getPositions($latitude, $longitude)
    {
        $rad = rad2deg(self::RADIAN);
        list($positions) = Db::query("SELECT FLOOR({$latitude} - {$rad}) as lat_lb, CEILING({$latitude} + {$rad}) as lat_ub, FLOOR({$longitude} - {$rad}) as lon_lb, CEILING({$longitude} + {$rad}) as lon_ub");
        $data['latitudes'] = range($positions['lat_lb'], $positions['lat_ub']);
        $data['longitudes'] = range($positions['lon_lb'], $positions['lon_ub']);
        return $data;
    }

    /***
     * 获取商家详情,1031改动,便于cx调用
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBizDetail($params)
    {
        $where['id'] = $params['seller_id'];
        $subQuery = Db::name('homepage_cate')->alias('hc')->field('GROUP_CONCAT(hc.catename)')->where('FIND_IN_SET(hc.id,s.homepage_cate_parent_id)')->buildSql();

        if(isset($params['lat']) || isset($params['lon'])){

            $field = "s.id,s.sellername,s.homepage_cate_parent_id,s.contactphone,s.remark,
        s.start_time,s.end_time,s.address,s.seller_pic2,s.lon,s.lat,{$subQuery} as hccatename,
        ROUND(6378.138 * 2 * ASIN(SQRT(POW( SIN( (".$params['lat']." * PI() / 180 - lat * PI() / 180 ) / 2),2) + COS(".$params['lat']." * PI() / 180) * COS(lat * PI() / 180) * POW(SIN( (".$params['lon']." * PI() / 180 - lon * PI() / 180) / 2),2))) * 1000) AS `range`";

        } else {

            $field =  "s.id,s.sellername,s.homepage_cate_parent_id,s.contactphone,s.remark,
        s.start_time,s.end_time,s.address,s.seller_pic2,s.lon,s.lat,{$subQuery} as hccatename";

        }

        return $this->field($field)->alias('s')->where($where)->find();
    }

    /***
     * 用户端扫码获取商家信息
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBizInfo($params)
    {
        $where['id'] = $params['seller_id'];
        $field = 'id,sellername,seller_pic3,address,is_review,is_disabled';
        return $this->field($field)->where($where)->find();
    }

    /***
     * 获取当前商家的服务类别11/1
     * @param $params
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getHomePageCateParentId($params)
    {
        $where['id'] = $params['seller_id'];
        $field = 'homepage_cate_parent_id';
        return $this->field($field)->where($where)->find();
    }

    /**
     * 商家端列表
     * @param serve_id 服务id
     * @param page 页数
     * @param area_code 区域id
     * @param lon 经度
     * @param lat 纬度
     */
    public function sellerList($params)
    {
        $params['page'] = $params['page'] ? $params['page'] : 1;
        if(!empty($$params['serve_id'])){          //服务id对应的商家列表
            $map = "FIND_IN_SET('".$params['serve_id']."',homepage_cate_parent_id) and is_review = 1 and is_disabled = 0";
        }else{         //首页推荐商家的商家列表
            $map['is_review'] = 1;              //是否加盟(0待处理,1已加盟)
            $map['is_disabled'] = 0;            //是否下架(0不下架,1下架)
            $map['is_recommend'] = 1;           //推荐商家(0不推,1推)
            // 截取区域id的前三位
            $area_code = substr($params['area_code'], 0, 3);
            $map['area_code'] = ['like', "%$area_code%"];
        }
        if(!empty($params['lat']) || !empty($params['lon'])){
            $field = "id,sellername,lon,lat,address,seller_pic3,
        ROUND(6378.138 * 2 * ASIN(SQRT(POW( SIN( (".$params['lat']." * PI() / 180 - lat * PI() / 180 ) / 2),2) + COS(".$params['lat']." * PI() / 180) * COS(lat * PI() / 180) * POW(SIN( (".$params['lon']." * PI() / 180 - lon * PI() / 180) / 2),2))) * 1000) AS `range`";
        }else{
            $field = "id,sellername,lon,lat,address,seller_pic3";
        }
        $result = $this
            ->where($map)
            ->field($field)
            ->page($params['page'],30)
            ->order('order_num')
            ->select();
        return $result ? $result : [];
    }

    /**
     * 搜索列表
     * @param keywords 搜索词
     * @param page 页数
     */
    public function searchList($keywords,$page,$lat = 0,$lon = 0)
    {
        $page = $page ? $page : 1;
        $map['is_review'] = 1;//是否加盟(0待处理,1已加盟)
        $map['is_disabled'] = 0;//是否下架(0不下架,1下架)
        $map['sellername']  = ['like',"%$keywords%"];
        $field = "id,sellername,lon,lat,address,seller_pic3,
        ROUND(6378.138 * 2 * ASIN(SQRT(POW( SIN( ({$lat} * PI() / 180 - lat * PI() / 180 ) / 2),2) + COS({$lat} * PI() / 180) * COS(lat * PI() / 180) * POW(SIN( ({$lon} * PI() / 180 - lon * PI() / 180) / 2),2))) * 1000) AS `range`";
        $result = $this->where($map)
                ->page($page,30)
                ->field($field)
                ->select();
        return $result ? $result : [];
    }

    /**
     * 查询当前商家是否有手续费率
     * @param sellerId 商家id
     */
    public function sellerFee($sellerId){
        $result = $this->where('id',$sellerId)->field("fee")->find();
        return $result ? $result : [];
    }
}