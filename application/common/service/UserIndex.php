<?php
namespace app\common\service;
use app\common\logic\UserIndex as UserIndexLogic;

class UserIndex extends Base{
    protected $UserIndexLogic = null;

    public function __construct(){
        parent::__construct();
        $this->UserIndexLogic = new UserIndexLogic;
    }

    /**
     * 首页轮播图
     */
    public function carousel()
    {
        $data = $this->UserIndexLogic->carousel();
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 首页服务模块
     */
    public function service()
    {
        $data = $this->UserIndexLogic->service();
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 首页推荐商家端列表
     * @param serve_id 服务id
     * @param lon 经度
     * @param lat 纬度
     * @param page 页数
     * @param area_code 区域id
     */
    public function sellerList($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'sellerList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserIndexLogic->sellerList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 我的收藏列表
     * @param user_id 用户id
     * @param lon 经度
     * @param lat 纬度
     * @param page 页数
     */
    public function myCollectList($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'myCollectList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserIndexLogic->sellerList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 取消收藏
     * @param user_id 用户id
     * @param seller_id 商家id
     */
    public function removeCollect($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'removeCollect')) {
            $this->message = $validate->getError();
            return;
        }
        try {
            $this->UserIndexLogic->removeCollect($params);
            list($this->status, $this->message) = [1, "取消收藏成功!"];
        } catch (Exception $e) {
            list($this->status, $this->message) = [0, "取消收藏失败!"];
        }
        return;
    }

    /**
     * 获取 搜索历史|热门搜索
     * @param user_id 用户id
     */
    public function searchHistory($params){
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserIndexLogic->searchHistory($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 清空历史搜索记录
     * @param user_id 用户id
     */
    public function clearSearch($params){
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'msgList')) {
            $this->message = $validate->getError();
            return;
        }
        try {
            $this->UserIndexLogic->clearSearch($params);
            list($this->status, $this->message) = [1, "清除成功"];
        } catch (Exception $e) {
            list($this->status, $this->message) = [0, "清除失败"];
        }
        return;
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
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'searchList')) {
            $this->message = $validate->getError();
            return;
        }
        $this->UserIndexLogic->addSearch($params);//添加搜索记录
        $data = $this->UserIndexLogic->searchList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 首页定位列表
     * @param user_id 用户id
     */
    public function locationList($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'locationList')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserIndexLogic->locationList($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 添加定位历史
     * @param user_id 用户id
     * @param latitude 地名
     * @param area_code 区域id
     */
    public function locationHistory($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'locationHistory')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserIndexLogic->locationHistory($params);
        if(!empty($data)){
            list($this->status, $this->message) = [1, "请求成功"];
        }else{
            list($this->status, $this->message) = [0, "请求失败"];
        }
        return;
    }

    /**
     * 切换区县
     * @param area_code 地区区号
     */
    public function switchArea($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'switchArea')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserIndexLogic->switchArea($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }

    /**
     * 搜索城市
     * @param areaname 城市名称
     */
    public function searchCity($params)
    {
        $validate = validate('UserValidate');
        if (!$validate->check($params, [],'searchCity')) {
            $this->message = $validate->getError();
            return;
        }
        $data = $this->UserIndexLogic->searchCity($params);
        list($this->status, $this->message, $this->data) = [1, "请求成功", $data];
        return;
    }



}