<?php
/**
 * 陈鑫 Visual Studio
 */
namespace app\api\controller\v1;
use app\api\controller\Base;
use think\Request;
use app\common\service\UserIndex as UserIndexService;
/**
 * 用户端首页模块接口类
 * Class UserIndex
 * @package app\api\controller\v1
 */
class UserIndex extends Base
{
    protected $UserIndexService = null;

    function __construct(Request $request = null){
        $this->UserIndexService = new UserIndexService;
        parent::__construct($request);
    }

    /**
     * 首页轮播图
     */
    public function carousel()
    {
        $this->UserIndexService->carousel();
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 首页服务模块
     */
    public function service()
    {
        $this->UserIndexService->service();
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 首页推荐商家端列表
     * @param serve_id 服务id
     * @param lon 经度
     * @param lat 纬度
     * @param page 页数
     * @param area_code 区域id
     */
    public function sellerList()
    {
        $params = [
            'serve_id' => input('serve_id', '', 'trim'),//服务id
            'lon' => input('lon', '', 'trim'),//经度
            'lat' => input('lat', '', 'trim'),//纬度
            'page' => input('page','','trim'),//页数
            'area_code' =>  input('area_code','','trim'),//区域id
        ];
        $this->UserIndexService->sellerList($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 我的收藏列表
     * @param user_id 用户id
     * @param lon 经度
     * @param lat 纬度
     * @param page 页数
     */
    public function myCollectList()
    {
        $params = [
            'user_id' => $this->uid,
            'lon' => input('lon', '', 'trim'),//经度
            'lat' => input('lat', '', 'trim'),//纬度
            'page' => input('page','','trim'),//页数
        ];
        $this->UserIndexService->myCollectList($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 取消收藏
     * @param user_id 用户id
     * @param seller_id 商家id
     */
    public function removeCollect()
    {
        $params = [
            'user_id' => $this->uid,
            'seller_id' => input('seller_id','','trim'),
        ];
        $this->UserIndexService->removeCollect($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 获取 搜索历史|热门搜索
     * @param user_id 用户id
     */
    public function searchHistory(){
        $params = [
            'user_id' => $this->uid,
        ];
        $this->UserIndexService->searchHistory($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 清空历史搜索记录
     * @param user_id 用户id
     */
    public function clearSearch(){
        $params = [
            'user_id' => $this->uid,
        ];
        $this->UserIndexService->clearSearch($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 搜索列表
     * @param user_id 用户id
     * @param keywords 搜索词
     * @param lon 经度
     * @param lat 纬度
     * @param page 页数
     */
    public function searchList()
    {
        $params = [
            'user_id' => $this->uid,
            'keywords' => input('keywords','','trim'),
            'lon' => input('lon', '', 'trim'),//经度
            'lat' => input('lat', '', 'trim'),//纬度
            'page' => input('page','','trim'),//页数
        ];
        $this->UserIndexService->searchList($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 首页定位列表
     * @param user_id 用户id
     */
    public function locationList()
    {
        $params = [
            'user_id' => $this->uid,
        ];
        $this->UserIndexService->locationList($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 切换区县
     * @param area_code 地区区号
     */
    public function switchArea()
    {
        $params = [
            'area_code' => input('area_code','','trim'),//地区区号
        ];
        $this->UserIndexService->switchArea($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 搜索城市
     * @param areaname 城市名称
     */
    public function searchCity()
    {
        $params = [
            'areaname' => input('areaname','','trim'),//城市名称
        ];
        $this->UserIndexService->searchCity($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }

    /**
     * 添加定位历史
     * @param user_id 用户id
     * @param latitude 地名
     * @param area_code 区域id
     */
    public function locationHistory()
    {
        $params = [
            'user_id' => $this->uid,
            'latitude' => input('latitude','','trim'),//地名
            'area_code' => input('area_code','','trim'),//区域id
        ];
        $this->UserIndexService->locationHistory($params);
        list($this->status, $this->message, $this->data) = [$this->UserIndexService->status, $this->UserIndexService->message, $this->UserIndexService->data];
    }


}