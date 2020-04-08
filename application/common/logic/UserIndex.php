<?php
namespace app\common\logic;
use app\common\model\HomepageCate as HomepageCateModel;
use app\common\model\HomepageArea as HomepageAreaModel;
use app\common\model\HomepageCarousel as HomepageCarouselModel;
use app\common\model\Seller as SellerModel;
use app\common\model\Collect as CollectModel;
use app\common\model\Comment as CommentModel;
use app\common\model\Hotsearch as HotsearchModel;

class UserIndex extends Base{
    protected $HomepageCateModel = null;
    protected $HomepageAreaModel = null;
    protected $HomepageCarouselModel = null;
    protected $SellerModel = null;
    protected $CollectModel = null;
    protected $CommentModel = null;
    protected $HotsearchModel = null;

    public function __construct(){
        parent::__construct();
        $this->HomepageCateModel = new HomepageCateModel;
        $this->HomepageAreaModel = new HomepageAreaModel;
        $this->HomepageCarouselModel = new HomepageCarouselModel;
        $this->SellerModel = new SellerModel;
        $this->CollectModel = new CollectModel;
        $this->CommentModel = new CommentModel;
        $this->HotsearchModel = new HotsearchModel;
    }

    /**
     * 首页轮播图
     */
    public function carousel()
    {
        $data = [];
        $result = $this->HomepageCarouselModel->carousel();
        foreach($result as $k=>&$val){
            $val['picture'] = Rtrim(config('token.web_site_domain'),'/').get_file_path($val['picture']);
            $data[$k] = $val;
            $data[$k]['link_url'] = $val['info_id'];
            if($val['type'] == 'web'){
                $data[$k]['link_url'] = $val['linkurl'];
            }
            unset($data[$k]['linkurl']);
            unset($data[$k]['info_id']);
        }
        return $data ? $data : [];
    }

    /**
     * 首页服务模块
     */
    public function service()
    {
        $result = $this->HomepageCateModel->getBusiness();
        foreach($result as &$val){
            $val['icon'] = config('token.web_site_domain').get_file_path($val['icon']);
        }
        return $result ? $result : [];
    }

    /**
     * 首页推荐商家端列表|对应服务id的商家列表 |我的收藏列表
     * @param serve_id 服务id
     * @param lon 经度
     * @param lat 纬度
     * @param page 页数
     * @param user_id 用户id
     * @param keywords 搜索词
     * @param area_code 区域id
     */
    public function sellerList($params)
    {
        $data = [];
        if(!empty($params['user_id'])){//我的收藏列表
            $result = $this->CollectModel->myCollectList($params['user_id'],$params['page'],$params['lat'],$params['lon']);
        }else{//首页推荐商家端列表|对应服务id的商家列表
            $result = $this->SellerModel->sellerList($params);
        }
        if(!empty($result)){
            foreach($result as $k=>&$val){
                if($val['id'] != NULL){
                    $seller_comment_count = $this->CommentModel->seller_comment_count($val['id']);
                    $val['seller_pic3'] = config('token.web_site_domain').get_file_path($val['seller_pic3']);//转换图片路径
                    $val['totalComment'] = $seller_comment_count;//获取评价数量
                    $val['range'] =  judgeDistance($val['range']);//计算距离
                    $data[$k] = $val;
                    unset($data[$k]['lon']);
                    unset($data[$k]['lat']);
                }
            }
        }
        return $data ? $data : [];
    }

    /**
     * 取消收藏
     * @param user_id 用户id
     * @param seller_id 商家id
     */
    public function removeCollect($params)
    {
        return $this->CollectModel->removeCollect($params['user_id'],$params['seller_id']);
    }

    /**
     * 获取 搜索历史|热门搜索
     * @param user_id 用户id
     */
    public function searchHistory($params){
        $data = [];
        $history = $this->HotsearchModel->searchHistory($params['user_id']);
        $hot = $this->HotsearchModel->searchHot();
        $data = ['history'=>$history, 'hot'=>$hot];
        return $data;
    }

    /**
     * 清空历史搜索记录
     * @param user_id 用户id
     */
    public function clearSearch($params){
        return $this->HotsearchModel->clearSearch($params['user_id']);
    }

    /**
     * 添加搜索记录
     * @param user_id 用户id
     * @param keywords 搜索词
     */
    public function addSearch($params)
    {
        $this->HotsearchModel->addSearch($params);
    }

    /**
     * 搜索列表
     * @param user_id 用户id
     * @param keywords 搜索词
     * @param lon 经度
     * @param lat 纬度
     * @param page 页数
     */
    public function searchList($params)
    {
        $data = [];
        $result = $this->SellerModel->searchList($params['keywords'],$params['page'],$params['lat'],$params['lon']);
        if(!empty($result)){
            foreach($result as $k=>&$val){
                if($val['id'] != NULL){
                    $seller_comment_count = $this->CommentModel->seller_comment_count($val['id']);
                    $val['seller_pic3'] = config('token.web_site_domain').get_file_path($val['seller_pic3']);//转换图片路径
                    $val['totalComment'] = $seller_comment_count;//获取评价数量
                    $val['range'] =  judgeDistance($val['range']);//计算距离
                    $data[$k] = $val;
                    unset($data[$k]['lon']);
                    unset($data[$k]['lat']);
                }
            }
        }
        return $data ? $data : [];
    }

    /**
     * 首页定位列表
     * @param user_id 用户id
     */
    public function locationList($params)
    {
        // 1.获取 区域城市的列表
        $areaList = $this->HomepageAreaModel->getProvince();
        foreach($areaList as &$val){
            if($val['type'] ==0){
                $val['type'] = 1;//一级城市
            }else{
                $val['type'] = 2;//二级城市
            }
        }
        unset($val);
        $history = [];
        // 2.获取 用户的历史定位记录
        $areaHistory = $this->HomepageAreaModel->areaHistory($params['user_id']);
        // 通过area_code来判断城市等级
        foreach($areaHistory as $k => $val){
            $history[] = $val;
            $history[$k]['type'] = 2;
            if(substr($val['area_code'],3,3) == '000'){//一级城市后缀为000
                $history[$k]['type'] = 1;
            }
        }
        $result = ['areaList' => $areaList, 'areaHistory' => $history];
        return $result;
    }

    /**
     * 添加定位历史
     * @param user_id 用户id
     * @param latitude 地名
     * @param area_code 区域id
     */
    public function locationHistory($params)
    {
        return $this->HomepageAreaModel->addUserLocal($params);
    }

    /**
     * 获取一级城市下的区县
     * @param area_code 地区区号
     */
    public function switchArea($params)
    {
        //  获取地区区号 前三位
        $params['area_code'] = substr($params['area_code'], 0, 3);
        $areaList = $this->HomepageAreaModel->switchArea($params['area_code']);
        if(!empty($areaList)){
            foreach($areaList as &$val){
                if($val['type'] ==0){
                    $val['type'] = 1;//一级城市
                }else{
                    $val['type'] = 2;//二级城市
                }
            }
        }
        return $areaList;
    }

    /**
     * 搜索城市
     * @param areaname 城市名称
     */
    public function searchCity($params)
    {
        $areaList = $this->HomepageAreaModel->searchCity($params['areaname']);
        if(!empty($areaList)){
            foreach($areaList as &$val){
                if($val['type'] ==0){
                    $val['type'] = 1;//一级城市
                }else{
                    $val['type'] = 2;//二级城市
                }
            }
        }
        return $areaList;
    }

}